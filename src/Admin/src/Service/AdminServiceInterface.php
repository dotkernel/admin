<?php

namespace Frontend\Admin\Service;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Frontend\Admin\Entity\Admin;
use Frontend\Admin\Entity\AdminLogin;
use Frontend\Admin\Repository\AdminRepository;

/**
 * Class AdminService
 * @package Frontend\Admin\Service
 *
 * @Service
 */
interface AdminServiceInterface
{
    /**
     * @return AdminRepository
     */
    public function getAdminRepository(): AdminRepository;

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
     * @param array $data
     * @return Admin
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createAdmin(array $data): Admin;

    /**
     * @param array $serverParams
     * @param string $name
     * @return AdminLogin
     */
    public function logAdminVisit(array $serverParams, string $name): AdminLogin;
}
