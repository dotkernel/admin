<?php

namespace Frontend\User\Service;

use Frontend\User\Entity\UserRole;

/**
 * Class UserRoleService
 * @package Frontend\User\Service
 */
interface UserRoleServiceInterface
{
    /**
     * @param array $params
     * @return UserRole|null
     */
    public function findOneBy(array $params = []): ?UserRole;
}
