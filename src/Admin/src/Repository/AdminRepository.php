<?php

declare(strict_types=1);

namespace Frontend\Admin\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Frontend\Admin\Entity\Admin;
use Frontend\Admin\Entity\AdminLogin;
use Frontend\App\Repository\AbstractRepository;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Throwable;

class AdminRepository extends AbstractRepository
{
    protected int $cacheLifetime = 0;

    public function saveAdmin(Admin $admin): Admin
    {
        $this->getEntityManager()->persist($admin);
        $this->getEntityManager()->flush();

        return $admin;
    }

    public function saveAdminVisit(AdminLogin $adminLogin): AdminLogin
    {
        $this->getEntityManager()->persist($adminLogin);
        $this->getEntityManager()->flush();

        return $adminLogin;
    }

    public function deleteAdmin(Admin $admin): void
    {
        $this->getEntityManager()->remove($admin);
        $this->getEntityManager()->flush();
    }

    public function exists(string $identity): bool
    {
        if (empty($identity)) {
            return false;
        }

        try {
            $result = $this->getQueryBuilder()->select('admin')
                ->from(Admin::class, 'admin')
                ->andWhere('admin.identity = :identity')
                ->setParameter('identity', $identity)->getQuery()->getSingleResult();
        } catch (Throwable) {
            $result = null;
        }

        return $result instanceof Admin;
    }

    public function getAdmins(
        int $offset = 0,
        int $limit = 30,
        ?string $search = null,
        string $sort = 'created',
        string $order = 'desc'
    ): mixed {
        $qb = $this->getQueryBuilder();

        $qb->select('admin')
            ->from(Admin::class, 'admin')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('admin.' . $sort, $order);

        if (! empty($search)) {
            $qb->andWhere($qb->expr()->like('admin.identity', ':search'))
                ->setParameter('search', '%' . $search . '%');
        }

        return $qb->getQuery()->useQueryCache(true)->getResult();
    }

    /**
     * @return AdminLogin[]
     */
    public function getAdminLogins(
        int $offset = 0,
        int $limit = 30,
        string $sort = 'created',
        string $order = 'desc'
    ): array {
        return $this->getQueryBuilder()
            ->select('adminLogin')
            ->from(AdminLogin::class, 'adminLogin')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('adminLogin.' . $sort, $order)
            ->getQuery()
            ->useQueryCache(true)
            ->getResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function countAdmins(?string $search = null): mixed
    {
        if (empty($search)) {
            return $this->countAllAdmins();
        }

        return $this->getQueryBuilder()
            ->select('count(admin)')
            ->from(Admin::class, 'admin')
            ->andWhere('admin.identity = :search')
            ->setParameter('search', '%' . $search . '%')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    protected function countAllAdmins(): mixed
    {
        return $this->getQueryBuilder()
            ->select('count(admin)')
            ->from(Admin::class, 'admin')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function countAdminLogins(): mixed
    {
        return $this->getQueryBuilder()
            ->select('count(adminLogin)')
            ->from(AdminLogin::class, 'adminLogin')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getCacheLifetime(): int
    {
        return $this->cacheLifetime;
    }

    public function setCacheLifetime(int $cacheLifetime): self
    {
        $this->cacheLifetime = $cacheLifetime;

        return $this;
    }

    public function findAdminBy(array $params): ?Admin
    {
        if (empty($params)) {
            return null;
        }

        try {
            $qb = $this->getQueryBuilder()->select('admin')->from(Admin::class, 'admin');
            $this->addUuidFilter($qb, $params['uuid'] ?? null);
            $this->addIdentityFilter($qb, $params['identity'] ?? null);

            return $qb->getQuery()->getSingleResult();
        } catch (Throwable) {
            return null;
        }
    }

    public function addUuidFilter(QueryBuilder $qb, ?string $uuid): void
    {
        if (! empty($uuid)) {
            $qb->andWhere('admin.uuid = :admin_uuid')
                ->setParameter('admin_uuid', $uuid, UuidBinaryOrderedTimeType::NAME);
        }
    }

    public function addIdentityFilter(QueryBuilder $qb, ?string $identity): void
    {
        if (! empty($identity)) {
            $qb->andWhere('admin.identity = :admin_identity')->setParameter('admin_identity', $identity);
        }
    }
}
