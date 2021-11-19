<?php

declare(strict_types=1);

namespace Frontend\User\Service;

use Doctrine\ORM\EntityManager;
use Dot\AnnotatedServices\Annotation\Inject;
use Frontend\User\Entity\AdminRole;
use Frontend\User\Entity\UserRole;
use Frontend\User\Repository\AdminRoleRepository;
use Frontend\User\Repository\UserRoleRepository;

/**
 * Class UserRoleService
 * @package Frontend\Admin\Service
 */
class UserRoleService implements UserRoleServiceInterface
{
    protected AdminRoleRepository $adminRoleRepository;

    protected UserRoleRepository $userRoleRepository;

    /**
     * RoleService constructor.
     * @param EntityManager $entityManager
     *
     * @Inject({EntityManager::class})
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->adminRoleRepository = $entityManager->getRepository(AdminRole::class);
        $this->userRoleRepository = $entityManager->getRepository(UserRole::class);
    }

    /**
     * @return AdminRoleRepository
     */
    public function getAdminRoleRepository(): AdminRoleRepository
    {
        return $this->adminRoleRepository;
    }

    /**
     * @return UserRoleRepository
     */
    public function getUserRoleRepository(): UserRoleRepository
    {
        return $this->userRoleRepository;
    }
}
