<?php

declare(strict_types=1);

namespace Frontend\Admin\Service;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Frontend\Admin\Entity\Admin;
use Frontend\Admin\Entity\AdminLogin;
use Frontend\Admin\Repository\AdminRepository;
use MaxMind\Db\Reader\InvalidDatabaseException;

/**
 * Interface AdminServiceInterface
 * @package Frontend\Admin\Service
 */
interface AdminServiceInterface
{
    /**
     * @return AdminRepository|EntityRepository
     */
    public function getAdminRepository(): AdminRepository|EntityRepository;

    /**
     * @param string $identity
     * @return bool
     */
    public function exists(string $identity = ''): bool;

    /**
     * @param int $offset
     * @param int $limit
     * @param string|null $search
     * @param string $sort
     * @param string $order
     * @return array
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getAdmins(
        int $offset = 0,
        int $limit = 30,
        string $search = null,
        string $sort = 'created',
        string $order = 'desc'
    ): array;

    /**
     * @param int $offset
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @return array
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getAdminLogins(
        int $offset = 0,
        int $limit = 30,
        string $sort = 'created',
        string $order = 'desc'
    ): array;

    /**
     * @param array $data
     * @return Admin
     * @throws NonUniqueResultException
     * @throws ORMException
     */
    public function createAdmin(array $data): Admin;

    /**
     * @param Admin $admin
     * @param array $data
     * @return Admin
     * @throws ORMException
     */
    public function updateAdmin(Admin $admin, array $data): Admin;

    /**
     * @param array $serverParams
     * @param string $name
     * @return AdminLogin
     * @throws InvalidDatabaseException
     */
    public function logAdminVisit(array $serverParams, string $name): AdminLogin;

    /**
     * @param array $params
     * @return Admin|null
     */
    public function findAdminBy(array $params): ?Admin;

    /**
     * @return array
     */
    public function getAdminFormProcessedRoles(): array;
}
