<?php

declare(strict_types=1);

namespace Frontend\User\Service;

use Frontend\User\Entity\AdminRole;
use Frontend\User\Repository\AdminRoleRepository;
use Doctrine\ORM\EntityManager;
use Dot\AnnotatedServices\Annotation\Inject;

/**
 * Class UserRoleService
 * @package Frontend\Admin\Service
 */
class UserRoleService implements UserRoleServiceInterface
{
    /** @var AdminRoleRepository $roleRepository */
    protected $roleRepository;

    /**
     * RoleService constructor.
     * @param EntityManager $entityManager
     *
     * @Inject({EntityManager::class})
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->roleRepository = $entityManager->getRepository(AdminRole::class);
    }

    /**
     * @param array $params
     * @return AdminRole|null
     */
    public function findOneBy(array $params = []): ?AdminRole
    {
        if (empty($params)) {
            return null;
        }

        /** @var AdminRole $role */
        $role = $this->roleRepository->findOneBy($params);

        return $role;
    }
}
