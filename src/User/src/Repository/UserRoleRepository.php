<?php

declare(strict_types=1);

namespace Frontend\User\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Frontend\App\Repository\AbstractRepository;
use Frontend\User\Entity\AdminRole;
use Frontend\User\Entity\UserRole;

/**
 * Class UserRoleRepository
 * @package Frontend\User\Repository
 */
class UserRoleRepository extends AbstractRepository
{
    /**
     * @param string $uuid
     * @return UserRole|null
     * @throws NonUniqueResultException
     */
    public function getRole(string $uuid): ?UserRole
    {
        return $this->find($uuid);
    }

    /**
     * @param string $name
     * @return AdminRole|null
     * @throws NonUniqueResultException
     */
    public function findByName(string $name): ?UserRole
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
    public function getRoles(): array
    {
        return $this->findAll();
    }
}
