<?php

declare(strict_types=1);

namespace Frontend\User\Repository;

use Frontend\App\Repository\AbstractRepository;
use Frontend\User\Entity\UserRole;

/**
 * Class UserRoleRepository
 * @package Frontend\Admin\Repository
 */
class UserRoleRepository extends AbstractRepository
{
    /**
     * @param string $name
     * @return UserRole|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByName(string $name): ?UserRole
    {
        $qb = $this->getQueryBuilder();

        $qb
            ->select('role')
            ->from(UserRole::class, 'role')
            ->andWhere('role.name = :name')
            ->setParameter('name', $name);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
