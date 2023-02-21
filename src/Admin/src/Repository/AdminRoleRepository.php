<?php

declare(strict_types=1);

namespace Frontend\Admin\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Frontend\App\Repository\AbstractRepository;
use Frontend\Admin\Entity\AdminRole;

/**
 * Class AdminRoleRepository
 * @package Frontend\Admin\Repository
 */
class AdminRoleRepository extends AbstractRepository
{
    /**
     * @param string $uuid
     * @return AdminRole|null
     * @throws NonUniqueResultException
     */
    public function getRole(string $uuid): ?AdminRole
    {
        /** @var AdminRole $role */
        $role = $this->find($uuid);
        return $role;
    }

    /**
     * @param string $name
     * @return AdminRole|null
     * @throws NonUniqueResultException
     */
    public function findByName(string $name): ?AdminRole
    {
        return $this->getQueryBuilder()
            ->select('role')
            ->from(AdminRole::class, 'role')
            ->andWhere('role.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->useQueryCache(true)
            ->getOneOrNullResult();
    }

    /**
     * @return AdminRole[]
     */
    public function getRoles(): array
    {
        return $this->findAll();
    }
}
