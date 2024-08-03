<?php

declare(strict_types=1);

namespace Admin\Admin\Repository;

use Admin\Admin\Entity\Admin;
use Admin\Admin\Entity\AdminLogin;
use Admin\App\Repository\AbstractRepository;
use Doctrine\ORM\NonUniqueResultException;
use Dot\DependencyInjection\Attribute\Entity;
use Throwable;

#[Entity(Admin::class)]
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
            $result = $this->findOneBy(['identity' => $identity]);
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

        return $qb->getQuery()->setCacheable(true)->getResult();
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
            ->setCacheable(true)
            ->orderBy('adminLogin.' . $sort, $order)
            ->getQuery()
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
}
