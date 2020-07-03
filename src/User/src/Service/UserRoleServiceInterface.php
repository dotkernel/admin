<?php

namespace Frontend\User\Service;

use Frontend\User\Repository\AdminRoleRepository;
use Frontend\User\Repository\UserRoleRepository;

/**
 * Class UserRoleService
 * @package Frontend\Admin\Service
 */
interface UserRoleServiceInterface
{
    /**
     * @return UserRoleRepository
     */
    public function getUserRoleRepository(): UserRoleRepository;

    /**
     * @return AdminRoleRepository
     */
    public function getAdminRoleRepository(): AdminRoleRepository;
}
