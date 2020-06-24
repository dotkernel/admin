<?php

declare(strict_types=1);

namespace Frontend\User\Repository;

use Frontend\App\Repository\AbstractRepository;
use Frontend\User\Entity\Admin;
use Frontend\User\Entity\AdminInterface;
use ProxyManager\Example\GhostObjectSkippedProperties\User;
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
     * @param string|null $uuid
     * @return int|mixed|string|null
     */
    public function exists(string $email = '', ?string $uuid = '')
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('user')
            ->from(Admin::class, 'user')
            ->where('user.identity = :email')->setParameter('email', $email);
        if (!empty($uuid)) {
            $qb->andWhere('user.uuid != :uuid')->setParameter('uuid', $uuid, UuidBinaryOrderedTimeType::NAME);
        }

        try {
            return $qb->getQuery()->getSingleResult();
        } catch (\Exception $exception) {
            return null;
        }
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
            $qb->where($qb->expr()->like('admin.email', ':search'))
                ->setParameter('search', '%' . $search . '%');
        }

        $qb->setFirstResult($offset)
            ->setMaxResults($limit);
        $qb->orderBy('admin.' . $sort, $order);

        return $qb->getQuery()->getResult();
    }
}
