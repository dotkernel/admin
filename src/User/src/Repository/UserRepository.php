<?php

declare(strict_types=1);

namespace Frontend\User\Repository;

use Frontend\App\Repository\AbstractRepository;
use Frontend\User\Entity\Admin;
use Frontend\User\Entity\AdminInterface;
use Frontend\User\Entity\User;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;

/**
 * Class UserRepository
 * @package Frontend\User\Repository
 */
class UserRepository extends AbstractRepository
{
    /**
     * @param string $identity
     * @return AdminInterface|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByIdentity(string $identity): ?AdminInterface
    {
        $qb = $this->getQueryBuilder();

        $qb
            ->select('user')
            ->from(Admin::class, 'user')
            ->andWhere('user.identity = :identity')
            ->setParameter('identity', $identity);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param string $identity
     * @return int|mixed|string|null
     */
    public function exists(string $identity = '')
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('user')
            ->from(User::class, 'user')
            ->where('user.identity = :identity')->setParameter('identity', $identity);

        try {
            return $qb->getQuery()->getSingleResult();
        } catch (\Exception $exception) {
            return null;
        }
    }

    /**
     * @param Admin $admin
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveAdmin(Admin $admin)
    {
        $this->getEntityManager()->persist($admin);
        $this->getEntityManager()->flush();
    }

    /**
     * @param User $user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveUser(User $user)
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * @param string $email
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUserByEmail(string $email)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('user')
            ->from(Admin::class, 'user')
            ->where('user.identity = :identity')->setParameter('identity', $email);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string|null $search
     * @param string $sort
     * @param string $order
     * @return int|mixed|string
     */
    public function getUsers(
        int $offset = 0,
        int $limit = 30,
        string $search = null,
        string $sort = 'created',
        string $order = 'desc'
    ) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('user')
            ->from(User::class, 'user');

        if (!is_null($search)) {
            $qb->where($qb->expr()->like('user.identity', ':search'))
                ->setParameter('search', '%' . $search . '%');
        }

        $qb->setFirstResult($offset)
            ->setMaxResults($limit);
        $qb->orderBy('user.' . $sort, $order);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param string|null $search
     * @return int|mixed|string
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countUsers(string $search = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('count(user)')
            ->from(User::class, 'user');

        if (!is_null($search)) {
            $qb->where($qb->expr()->like('user.identity', ':search'))
                ->setParameter('search', '%' . $search . '%');
        }

        return $qb->getQuery()->getSingleScalarResult();
    }
}
