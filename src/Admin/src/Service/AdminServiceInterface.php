<?php

declare(strict_types=1);

namespace Frontend\Admin\Service;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Frontend\Admin\Entity\Admin;
use Frontend\Admin\Entity\AdminLogin;
use Frontend\Admin\Repository\AdminRepository;

interface AdminServiceInterface
{
    public function getAdminRepository(): AdminRepository|EntityRepository;

    public function exists(string $identity = ''): bool;

    /**
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
     * @throws NonUniqueResultException
     */
    public function getAdminLogins(
        int $offset = 0,
        int $limit = 30,
        string $sort = 'created',
        string $order = 'desc'
    ): array;

    /**
     * @throws NonUniqueResultException
     * @throws ORMException
     */
    public function createAdmin(array $data): Admin;

    /**
     * @throws NonUniqueResultException
     * @throws ORMException
     */
    public function updateAdmin(Admin $admin, array $data): Admin;

    public function logAdminVisit(array $serverParams, string $name): AdminLogin;

    public function findAdminBy(array $params): ?Admin;

    public function getAdminFormProcessedRoles(): array;
}
