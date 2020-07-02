<?php

namespace Frontend\User\Service;

use Doctrine\ORM\ORMException;
use Frontend\User\Entity\Admin;
use Frontend\User\Repository\AdminRepository;

/**
 * Class AdminService
 * @package Frontend\User\Service
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
     * @param string $email
     * @param string $username
     * @return bool
     */
    public function exists(string $email = '', string $username = '');

    /**
     * @param int $offset
     * @param int $limit
     * @param string|null $search
     * @param string $sort
     * @param string $order
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getAdmins(
        int $offset = 0,
        int $limit = 30,
        string $search = null,
        string $sort = 'created',
        string $order = 'desc'
    );

    /**
     * @param array $data
     * @return Admin
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createAdmin(array $data);
}
