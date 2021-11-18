<?php

declare(strict_types=1);

namespace Frontend\User\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Frontend\App\Repository\AbstractRepository;
use Frontend\User\Entity\Admin;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Throwable;

/**
 * Class AdminRepository
 * @package Frontend\User\Repository
 */
class AdminRepository extends AbstractRepository
{
    protected int $cacheLifetime = 0;

    /**
     * @param Admin $admin
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveAdmin(Admin $admin)
    {
        $this->getEntityManager()->persist($admin);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Admin|object $admin
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function deleteAdmin(Admin $admin)
    {
        $this->getEntityManager()->remove($admin);
        $this->getEntityManager()->flush();
    }

    /**
     * @param string $identity
     * @return int|mixed|string|null
     */
    public function exists(string $identity)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('admin')
            ->from(Admin::class, 'admin');

        if (!empty($identity)) {
            $qb->where('admin.identity = :identity')->setParameter('identity', $identity);
        }

        try {
            return $qb->getQuery()->getSingleResult();
        } catch (Throwable $exception) {
            return null;
        }
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string|null $search
     * @param string $sort
     * @param string $order
     * @return int|mixed|string
     */
    public function getAdmins(
        int $offset = 0,
        int $limit = 30,
        string $search = null,
        string $sort = 'created',
        string $order = 'desc'
    ) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('admin')
            ->from(Admin::class, 'admin');

        if (!is_null($search)) {
            $qb->where($qb->expr()->like('admin.identity', ':search'))
                ->setParameter('search', '%' . $search . '%');
        }

        $qb->setFirstResult($offset)
            ->setMaxResults($limit);
        $qb->orderBy('admin.' . $sort, $order);

        return $qb->getQuery()->enableResultCache($this->getCacheLifetime())->getResult();
    }

    /**
     * @param string|null $search
     * @return int|mixed|string
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countAdmins(string $search = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('count(admin)')
            ->from(Admin::class, 'admin');

        if (!is_null($search)) {
            $qb->where($qb->expr()->like('admin.identity', ':search'))
                ->setParameter('search', '%' . $search . '%');
        }

        return $qb->getQuery()->getSingleScalarResult();
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
     */
    public function setCacheLifetime(int $cacheLifetime): void
    {
        $this->cacheLifetime = $cacheLifetime;
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

        $qb = $this->getQueryBuilder()->select('admin')->from(Admin::class, 'admin');
        $this->addUuidFilter($qb, $params['uuid'] ?? null);
        $this->addIdentityFilter($qb, $params['identity'] ?? null);

        try {
            return $qb->getQuery()->getSingleResult();
        } catch (Throwable $exception) {
            return null;
        }
    }

    /**
     * @param QueryBuilder $qb
     * @param string|null $uuid
     */
    public function addUuidFilter(QueryBuilder $qb, ?string $uuid): void
    {
        if (!empty($uuid)) {
            $qb->where('admin.uuid = :admin_uuid')
                ->setParameter('admin_uuid', $uuid, UuidBinaryOrderedTimeType::NAME);
        }
    }

    /**
     * @param QueryBuilder $qb
     * @param string|null $identity
     */
    public function addIdentityFilter(QueryBuilder $qb, ?string $identity): void
    {
        if (!empty($identity)) {
            $qb->where('admin.identity = :admin_identity')->setParameter('admin_identity', $identity);
        }
    }
}
