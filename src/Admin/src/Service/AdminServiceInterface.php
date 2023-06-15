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
 */
interface AdminServiceInterface
{
    public function getAdminRepository(): AdminRepository|EntityRepository;

    public function exists(string $identity = ''): bool;

    /**
     * @return array
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getAdmins(
        int $offset = 0,
        int $limit = 30,
        ?string $search = null,
        string $sort = 'created',
        string $order = 'desc'
    ): array;

    /**
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
     * @throws NonUniqueResultException
     * @throws ORMException
     */
    public function createAdmin(array $data): Admin;

    /**
     * @param array $data
     * @throws ORMException
     */
    public function updateAdmin(Admin $admin, array $data): Admin;

    /**
     * @param array $serverParams
     * @throws InvalidDatabaseException
     */
    public function logAdminVisit(array $serverParams, string $name): AdminLogin;

    /**
     * @param array $params
     */
    public function findAdminBy(array $params): ?Admin;

    /**
     * @return array
     */
    public function getAdminFormProcessedRoles(): array;
}
