<?php

declare(strict_types=1);

namespace Admin\Admin\Repository;

use Admin\Admin\Entity\AdminRole;
use Admin\App\Repository\AbstractRepository;
use Doctrine\ORM\NonUniqueResultException;
use Dot\DependencyInjection\Attribute\Entity;

#[Entity(AdminRole::class)]
class AdminRoleRepository extends AbstractRepository
{
    /**
     * @throws NonUniqueResultException
     */
    public function getRole(string $uuid): ?AdminRole
    {
        /** @var AdminRole $role */
        $role = $this->findOneBy(['uuid' => $uuid]);
        return $role;
    }

    /**
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
            ->setCacheable(true)
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
