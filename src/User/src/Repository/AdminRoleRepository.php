<?php

declare(strict_types=1);

namespace Frontend\User\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Frontend\App\Repository\AbstractRepository;
use Frontend\User\Entity\AdminRole;

/**
 * Class AdminRoleRepository
 * @package Frontend\User\Repository
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
        return $this->find($uuid);
    }

    /**
     * @param string $name
     * @return AdminRole|null
     * @throws NonUniqueResultException
     */
    public function findByName(string $name): ?AdminRole
    {
        $qb = $this->getQueryBuilder();

        $qb
            ->select('role')
            ->from(AdminRole::class, 'role')
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
