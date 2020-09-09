<?php

declare(strict_types=1);

namespace Frontend\User\Repository;

use Frontend\App\Repository\AbstractRepository;
use Frontend\User\Entity\AdminRole;
use Frontend\User\Entity\UserRole;

/**
 * Class UserRoleRepository
 * @package Frontend\Admin\Repository
 */
class UserRoleRepository extends AbstractRepository
{
    /**
     * @param string $uuid
     * @return object|null
     */
    public function getRole(string $uuid)
    {
        return $this->find($uuid);
    }

    /**
     * @param string $name
     * @return AdminRole|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByName(string $name): ?AdminRole
    {
        $qb = $this->getQueryBuilder();

        $qb
            ->select('role')
            ->from(UserRole::class, 'role')
            ->andWhere('role.name = :name')
            ->setParameter('name', $name);

        return $qb->getQuery()->useQueryCache(true)->getOneOrNullResult();
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->findAll();
    }
}
