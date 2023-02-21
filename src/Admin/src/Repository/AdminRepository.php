<?php

declare(strict_types=1);

namespace Frontend\Admin\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Frontend\App\Repository\AbstractRepository;
use Frontend\Admin\Entity\Admin;
use Frontend\Admin\Entity\AdminLogin;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Throwable;

/**
 * Class AdminRepository
 * @package Frontend\Admin\Repository
 */
class AdminRepository extends AbstractRepository
{
    protected int $cacheLifetime = 0;

    /**
     * @param Admin $admin
     * @return Admin
     */
    public function saveAdmin(Admin $admin): Admin
    {
        $this->getEntityManager()->persist($admin);
        $this->getEntityManager()->flush();

        return $admin;
    }

    /**
     * @param AdminLogin $adminLogin
     * @return AdminLogin
     */
    public function saveAdminVisit(AdminLogin $adminLogin): AdminLogin
    {
        $this->getEntityManager()->persist($adminLogin);
        $this->getEntityManager()->flush();

        return $adminLogin;
    }

    /**
     * @param Admin $admin
     * @return void
     */
    public function deleteAdmin(Admin $admin): void
    {
        $this->getEntityManager()->remove($admin);
        $this->getEntityManager()->flush();
    }

    /**
     * @param string $identity
     * @return bool
     */
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

    /**
     * @param int $offset
     * @param int $limit
     * @param string|null $search
     * @param string $sort
     * @param string $order
     * @return float|int|mixed|string
     */
    public function getAdmins(
        int $offset = 0,
        int $limit = 30,
        string $search = null,
        string $sort = 'created',
        string $order = 'desc'
    ): mixed {
        $qb = $this->getQueryBuilder();

        $qb->select('admin')
            ->from(Admin::class, 'admin')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('admin.' . $sort, $order);

        if (!is_null($search)) {
            $qb->andWhere($qb->expr()->like('admin.identity', ':search'))
                ->setParameter('search', '%' . $search . '%');
        }

        return $qb->getQuery()->useQueryCache(true)->getResult();
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $sort
     * @param string $order
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
     * @param string|null $search
     * @return float|int|mixed|string
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countAdmins(string $search = null): mixed
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
     * @return mixed
     * @throws NoResultException
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
     * @return float|int|mixed|string
     * @throws NoResultException
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

    /**
     * @return int
     */
    public function getCacheLifetime(): int
    {
        return $this->cacheLifetime;
    }

    /**
     * @param int $cacheLifetime
     * @return AdminRepository
     */
    public function setCacheLifetime(int $cacheLifetime): self
    {
        $this->cacheLifetime = $cacheLifetime;

        return $this;
    }

    /**
     * @param array $params
     * @return Admin|null
     */
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

    /**
     * @param QueryBuilder $qb
     * @param string|null $uuid
     * @return void
     */
    public function addUuidFilter(QueryBuilder $qb, ?string $uuid): void
    {
        if (!empty($uuid)) {
            $qb->andWhere('admin.uuid = :admin_uuid')
                ->setParameter('admin_uuid', $uuid, UuidBinaryOrderedTimeType::NAME);
        }
    }

    /**
     * @param QueryBuilder $qb
     * @param string|null $identity
     * @return void
     */
    public function addIdentityFilter(QueryBuilder $qb, ?string $identity): void
    {
        if (!empty($identity)) {
            $qb->andWhere('admin.identity = :admin_identity')->setParameter('admin_identity', $identity);
        }
    }
}
