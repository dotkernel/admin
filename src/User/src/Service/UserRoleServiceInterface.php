<?php

namespace Frontend\User\Service;

use Frontend\User\Entity\AdminRole;

/**
 * Class UserRoleService
 * @package Frontend\Admin\Service
 */
interface UserRoleServiceInterface
{
    /**
     * @param array $params
     * @return AdminRole|null
     */
    public function findOneBy(array $params = []): ?AdminRole;
}
