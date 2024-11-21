<?php

declare(strict_types=1);

namespace Admin\Admin\Service;

use Admin\Admin\Entity\Admin;
use Admin\Admin\Entity\AdminLogin;
use Admin\Admin\Repository\AdminRepository;
use Admin\App\Enum\SuccessFailureEnum;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;

interface AdminServiceInterface
{
    public function getAdminRepository(): AdminRepository;

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
        string $order = 'desc',
        array $filters = []
    ): array;

    public function getAdminLoginIdentities(): array;

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

    public function logAdminVisit(array $serverParams, string $name, SuccessFailureEnum $status): AdminLogin;

    public function getAdminFormProcessedRoles(): array;
}
