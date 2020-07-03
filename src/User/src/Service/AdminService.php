<?php

declare(strict_types=1);

namespace Frontend\User\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\ORMException;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;
use Doctrine\ORM\EntityManager;
use Frontend\User\Entity\AdminRole;
use Frontend\User\Repository\AdminRepository;
use Frontend\User\Entity\Admin;
use Frontend\User\Repository\AdminRoleRepository;

/**
 * Class AdminService
 * @package Frontend\User\Service
 *
 * @Service
 */
class AdminService implements AdminServiceInterface
{
    /** @var EntityManager $em */
    protected EntityManager $em;

    /** @var AdminRepository $adminRepository */
    protected AdminRepository $adminRepository;

    /** @var AdminRoleRepository $adminRoleRepository */
    protected AdminRoleRepository $adminRoleRepository;

    /**
     * AdminService constructor.
     * @param EntityManager $em
     *
     * @Inject({EntityManager::class})
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->adminRepository = $em->getRepository(Admin::class);
        $this->adminRoleRepository = $em->getRepository(AdminRole::class);
    }

    /**
     * @return AdminRepository
     */
    public function getAdminRepository(): AdminRepository
    {
        return $this->adminRepository;
    }

    /**
     * @param string $email
     * @param string $username
     * @return bool
     */
    public function exists(?string $email = '', ?string $username = '')
    {
        return !is_null(
            $this->adminRepository->exists($email, $username)
        );
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string|null $search
     * @param string $sort
     * @param string $order
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getAdmins(
        int $offset = 0,
        int $limit = 30,
        string $search = null,
        string $sort = 'created',
        string $order = 'desc'
    ) {
        $result = [
            'rows' => [],
            'total' => $this->getAdminRepository()->countAdmins($search)
        ];
        $admins = $this->getAdminRepository()->getAdmins($offset, $limit, $search, $sort, $order);

        /** @var Admin $admin */
        foreach ($admins as $admin) {
            $roles = [];
            /** @var AdminRole $role */
            foreach ($admin->getRoles() as $role) {
                $roles[] = $role->getName();
            }

            $result['rows'][] = [
                'uuid' => $admin->getUuid()->toString(),
                'username' => $admin->getUsername(),
                'email' => $admin->getEmail(),
                'firstName' => $admin->getFirstname(),
                'lastName' => $admin->getLastname(),
                'roles' => implode(", ", $roles),
                'status' => $admin->getStatus(),
                'created' => $admin->getCreated()->format("Y-m-d")
            ];
        }

        return $result;
    }

    /**
     * @param array $data
     * @return Admin
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createAdmin(array $data)
    {
        if ($this->exists($data['email'], $data['username'])) {
            throw new ORMException('An account with this email address or username already exists.');
        }

        $admin = new Admin();
        $admin->setEmail($data['email']);
        $admin->setUsername($data['username']);
        $admin->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
        $admin->setFirstname($data['firstName']);
        $admin->setLastname($data['lastName']);
        $admin->setStatus($data['status']);
        $role = $this->adminRoleRepository->getRole($data['roleUuid']);
        $admin->addRole($role);

        $this->getAdminRepository()->saveAdmin($admin);

        return $admin;
    }

    /**
     * @param Admin $admin
     * @param array $data
     * @return Admin
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateAdmin(Admin $admin, array $data)
    {
        if (!empty($data['email'])) {
            if (!$this->exists($data['email'])) {
                $admin->setEmail($data['email']);
            } elseif ($admin->getEmail() !== $data['email']) {
                throw new ORMException('An account with this email address already exists.');
            }
        }
        if (!empty($data['username'])) {
            if (!$this->exists(null, $data['username'])) {
                $admin->setUsername($data['username']);
            } elseif ($admin->getUsername() !== $data['username']) {
                throw new ORMException('An account with this username already exists.');
            }
        }
        if (!empty($data['password'])) {
            $admin->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
        }
        if (!empty($data['firstName'])) {
            $admin->setFirstname($data['firstName']);
        }
        if (!empty($data['lastName'])) {
            $admin->setLastname($data['lastName']);
        }
        if (!empty($data['status'])) {
            $admin->setStatus($data['status']);
        }
        if (!empty($data['roleUuid'])) {
            $role = $this->adminRoleRepository->getRole($data['roleUuid']);
            $admin->setRoles(new ArrayCollection());
            $admin->addRole($role);
        }

        $this->getAdminRepository()->saveAdmin($admin);

        return $admin;
    }
}
