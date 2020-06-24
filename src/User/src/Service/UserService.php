<?php

declare(strict_types=1);

namespace Frontend\User\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;
use Dot\Mail\Exception\MailException;
use Dot\Mail\Service\MailService;
use Frontend\App\Common\Message;
use Frontend\App\Common\UuidOrderedTimeGenerator;
use Frontend\User\Entity\Admin;
use Frontend\User\Entity\UserAvatar;
use Frontend\User\Entity\UserDetail;
use Frontend\User\Entity\AdminInterface;
use Frontend\User\Entity\UserRole;
use Frontend\User\Repository\UserRepository;
use Frontend\User\Repository\UserRoleRepository;
use Laminas\Diactoros\UploadedFile;
use Mezzio\Template\TemplateRendererInterface;

/**
 * Class UserService
 * @package Frontend\Admin\Service
 *
 * @Service()
 */
class UserService implements UserServiceInterface
{
    public const EXTENSIONS = [
        'image/jpg' => 'jpg',
        'image/jpeg' => 'jpg',
        'image/png' => 'png'
    ];

    /** @var EntityManager $em */
    protected $em;

    /** @var UserRepository $userRepository */
    protected $userRepository;

    /** @var UserRoleRepository $userRoleRepository */
    protected $userRoleRepository;

    /** @var UserRoleServiceInterface $userRoleService */
    protected $userRoleService;

    /** @var MailService $mailService */
    protected $mailService;

    /** @var TemplateRendererInterface $templateRenderer */
    protected $templateRenderer;

    /** @var array $config */
    protected $config;

    /**
     * UserService constructor.
     * @param EntityManager $em
     * @param @param UserRoleServiceInterface $userRoleService
     * @param MailService $mailService
     * @param TemplateRendererInterface $templateRenderer
     * @param array $config
     *
     * @Inject({EntityManager::class, UserRoleServiceInterface::class, MailService::class,
     *     TemplateRendererInterface::class, "config"})
     */
    public function __construct(
        EntityManager $em,
        UserRoleServiceInterface $userRoleService,
        MailService $mailService,
        TemplateRendererInterface $templateRenderer,
        array $config = []
    ) {
        $this->em = $em;
        $this->userRepository = $em->getRepository(Admin::class);
        $this->userRoleRepository = $em->getRepository(UserRole::class);
        $this->userRoleService = $userRoleService;
        $this->mailService = $mailService;
        $this->templateRenderer = $templateRenderer;
        $this->config = $config;
    }

    /**
     * @return UserRepository
     */
    public function getUserRepository(): UserRepository
    {
        return $this->userRepository;
    }

    /**
     * @return UserRoleRepository
     */
    public function getUserRoleRepository(): UserRoleRepository
    {
        return $this->userRoleRepository;
    }

    /**
     * @param array $data
     * @return AdminInterface
     * @throws \Exception
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createUser(array $data): AdminInterface
    {
        if ($this->exists($data['email'])) {
            throw new ORMException(Message::DUPLICATE_EMAIL);
        }

        $user = new Admin();
        $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT))->setIdentity($data['email']);

        $detail = new UserDetail();
        $detail->setUser($user)->setFirstName($data['detail']['firstName'])->setLastName($data['detail']['lastName']);

        $user->setDetail($detail);

        if (!empty($data['status'])) {
            $user->setStatus($data['status']);
        }

        if (!empty($data['roles'])) {
            foreach ($data['roles'] as $roleName) {
                $role = $this->userRoleRepository->findByName($roleName);
                if (!$role instanceof UserRole) {
                    throw new \Exception('Role not found: ' . $roleName);
                }
                $user->addRole($role);
            }
        } else {
            $role = $this->userRoleService->findOneBy(['name' => UserRole::ROLE_USER]);
            if ($role instanceof UserRole) {
                $user->addRole($role);
            }
        }

        if (empty($user->getRoles())) {
            throw new \Exception(Message::RESTRICTION_ROLES);
        }

        $this->userRepository->saveUser($user);

        return $user;
    }


    /**
     * @param Admin $user
     * @param array $data
     * @return Admin
     * @throws ORMException
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateUser(Admin $user, array $data = [])
    {
        if (isset($data['email']) && !is_null($data['email'])) {
            if ($this->exists($data['email'], $user->getUuid()->toString())) {
                throw new ORMException(Message::DUPLICATE_EMAIL);
            }
            $user->setIdentity($data['email']);
        }

        if (isset($data['password']) && !is_null($data['password'])) {
            $user->setPassword(
                password_hash($data['password'], PASSWORD_DEFAULT)
            );
        }

        if (isset($data['status']) && !empty($data['status'])) {
            $user->setStatus($data['status']);
        }

        if (isset($data['isDeleted']) && !is_null($data['isDeleted'])) {
            $user->setIsDeleted($data['isDeleted']);

            // make user anonymous
            $user->setIdentity('anonymous' . date('dmYHis') . '@dotkernel.com');
            $userDetails = $user->getDetail();
            $userDetails->setFirstName('anonymous' . date('dmYHis'));
            $userDetails->setLastName('anonymous' . date('dmYHis'));

            $user->setDetail($userDetails);
        }

        if (isset($data['hash']) && !empty($data['hash'])) {
            $user->setHash($data['hash']);
        }

        if (isset($data['detail']['firstName']) && !is_null($data['detail']['firstName'])) {
            $user->getDetail()->setFirstName($data['detail']['firstName']);
        }

        if (isset($data['detail']['lastName']) && !is_null($data['detail']['lastName'])) {
            $user->getDetail()->setLastName($data['detail']['lastName']);
        }

        if (!empty($data['avatar'])) {
            $user->setAvatar(
                $this->createAvatar($user, $data['avatar'])
            );
        }

        if (!empty($data['roles'])) {
            $user->resetRoles();
            foreach ($data['roles'] as $roleData) {
                $role = $this->userRoleService->findOneBy(['uuid' => $roleData['uuid']]);
                if ($role instanceof UserRole) {
                    $user->addRole($role);
                }
            }
        }
        if (empty($user->getRoles())) {
            throw new \Exception(Message::RESTRICTION_ROLES);
        }

        $this->userRepository->saveUser($user);

        return $user;
    }

    /**
     * @param Admin $user
     * @param UploadedFile $uploadedFile
     * @return UserAvatar
     */
    protected function createAvatar(Admin $user, UploadedFile $uploadedFile)
    {
        $path = $this->config['uploads']['user']['path'] . DIRECTORY_SEPARATOR;
        $path .= $user->getUuid()->toString() . DIRECTORY_SEPARATOR;
        if (!file_exists($path)) {
            mkdir($path, 0755);
        }

        if ($user->getAvatar() instanceof UserAvatar) {
            $avatar = $user->getAvatar();
            $this->deleteAvatarFile($path . $avatar->getName());
        } else {
            $avatar = new UserAvatar();
            $avatar->setUser($user);
        }
        $fileName = sprintf(
            'avatar-%s.%s',
            UuidOrderedTimeGenerator::generateUuid(),
            self::EXTENSIONS[$uploadedFile->getClientMediaType()]
        );
        $avatar->setName($fileName);

        $uploadedFile = new UploadedFile(
            $uploadedFile->getStream()->getMetadata()['uri'],
            $uploadedFile->getSize(),
            $uploadedFile->getError()
        );
        $uploadedFile->moveTo($path . $fileName);

        return $avatar;
    }

    /**
     * @param string $path
     * @return bool
     */
    public function deleteAvatarFile(string $path)
    {
        if (empty($path)) {
            return false;
        }

        if (is_readable($path)) {
            return unlink($path);
        }

        return false;
    }

    /**
     * @param string $email
     * @param string|null $uuid
     * @return bool
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function exists(string $email = '', ?string $uuid = '')
    {
        return !is_null(
            $this->userRepository->exists($email, $uuid)
        );
    }

    /**
     * @return array
     */
    public function getUsers(): array
    {
        return $this->userRepository->findAll();
    }

    /**
     * @param array $params
     * @return Admin|null
     */
    public function findOneBy(array $params = []): ?Admin
    {
        if (empty($params)) {
            return null;
        }

        /** @var Admin $user */
        $user = $this->userRepository->findOneBy($params);

        return $user;
    }

    /**
     * @param string $email
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getRoleNamesByEmail(string $email)
    {
        $roleList = [];

        /** @var Admin $user */
        $user = $this->userRepository->getUserByEmail($email);

        if (!empty($user)) {
            /** @var UserRole $role */
            foreach ($user->getRoles() as $role) {
                $roleList[] = $role->getName();
            }
        }

        return $roleList;
    }

    public function getAdmins(
        int $offset = 0,
        int $limit = 30,
        string $search = null,
        string $sort = 'created',
        string $order = 'desc'
    ) {
        $result = [
            'rows' => [],
            'total' => 0
        ];
        $admins = $this->getUserRepository()->getAdmins($offset, $limit, $search, $sort, $order);

        /** @var Admin $admin */
        foreach ($admins as $admin)
        {
            $result['rows'][] = [
                'uuid' => $admin->getUuid()->toString(),
                'username' => $admin->getUsername(),
                'email' => $admin->getEmail(),
                'firtname' => $admin->getFirstname(),
                'lastname' => $admin->getLastname(),
                'roles' => $admin->getRoles(),
                'status' => $admin->getStatus(),
                'created' => $admin->getCreated()
            ];
        }

        var_dump($result);exit;
    }
}
