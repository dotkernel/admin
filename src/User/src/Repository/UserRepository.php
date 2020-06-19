<?php

declare(strict_types=1);

namespace Frontend\User\Repository;

use Frontend\App\Repository\AbstractRepository;
use Frontend\User\Entity\Admin;
use Frontend\User\Entity\AdminInterface;
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
     * @param Admin $user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveUser(Admin $user)
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * @param string $email
     * @param string|null $uuid
     * @return mixed|null
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function exists(string $email = '', ?string $uuid = '')
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('user')
            ->from(Admin::class, 'user')
            ->where('user.identity = :email')->setParameter('email', $email)
            ->andWhere('user.isDeleted = :isDeleted')->setParameter('isDeleted', Admin::IS_DELETED_NO);
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
     * @param string $hash
     * @return Admin|null
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByResetPasswordHash(string $hash): ?Admin
    {
        try {
            $qb = $this->getEntityManager()->createQueryBuilder();
            $qb->select(['user', 'resetPasswords'])->from(Admin::class, 'user')
                ->leftJoin('user.resetPasswords', 'resetPasswords')
                ->andWhere('resetPasswords.hash = :hash')->setParameter('hash', $hash);

            return $qb->getQuery()->getSingleResult();
        } catch (\Exception $exception) {
            return null;
        }
    }
}
