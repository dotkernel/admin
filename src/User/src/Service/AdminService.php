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

    /** @var int $cacheLifetime */
    protected int $cacheLifetime;

    /**
     * AdminService constructor.
     * @param EntityManager $em
     * @param $cacheLifetime
     *
     * @Inject({EntityManager::class, "config.cacheLifetime"})
     */
    public function __construct(EntityManager $em, int $cacheLifetime)
    {
        $this->em = $em;
        $this->adminRepository = $em->getRepository(Admin::class);
        $this->adminRoleRepository = $em->getRepository(AdminRole::class);
        $this->adminRepository->setCacheLifetime($cacheLifetime);
    }

    /**
     * @return AdminRepository
     */
    public function getAdminRepository(): AdminRepository
    {
        return $this->adminRepository;
    }

    /**
     * @param string $identity
     * @return bool
     */
    public function exists(string $identity = '')
    {
        return !is_null(
            $this->adminRepository->exists($identity)
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
                'identity' => $admin->getIdentity(),
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
        if ($this->exists($data['identity'])) {
            throw new ORMException('An account with this identity already exists.');
        }

        $admin = new Admin();
        $admin->setIdentity($data['identity']);
        $admin->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
        $admin->setFirstname($data['firstName']);
        $admin->setLastname($data['lastName']);
        $admin->setStatus($data['status']);
        foreach ($data['roles'] as $roleUuid) {
            $role = $this->adminRoleRepository->getRole($roleUuid);
            $admin->addRole($role);
        }

        $this->getAdminRepository()->saveAdmin($admin);

        return $admin;
    }

    /**
     * @param Admin|object $admin
     * @param array $data
     * @return Admin
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateAdmin(Admin $admin, array $data)
    {
        if (!empty($data['identity'])) {
            if (!$this->exists($data['identity'])) {
                $admin->setIdentity($data['identity']);
            } elseif ($admin->getIdentity() !== $data['identity']) {
                throw new ORMException('An account with this identity already exists');
            }
        }
        if (!empty($data['password'])) {
            $admin->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
        }
        if (is_string($data['firstName'])) {
            $admin->setFirstname($data['firstName']);
        }
        if (is_string($data['lastName'])) {
            $admin->setLastname($data['lastName']);
        }
        if (!empty($data['status'])) {
            $admin->setStatus($data['status']);
        }
        if (!empty($data['roles'])) {
            $admin->setRoles(new ArrayCollection());
            foreach ($data['roles'] as $roleUuid) {
                $role = $this->adminRoleRepository->getRole($roleUuid);
                $admin->addRole($role);
            }
        }

        $this->getAdminRepository()->saveAdmin($admin);

        return $admin;
    }
}
