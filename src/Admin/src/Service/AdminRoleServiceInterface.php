<?php

declare(strict_types=1);

namespace Admin\Admin\Service;

use Admin\App\Exception\NotFoundException;
use Core\Admin\Entity\AdminRole;
use Core\Admin\Repository\AdminRoleRepository;

interface AdminRoleServiceInterface
{
    public function getAdminRoleRepository(): AdminRoleRepository;

    /**
     * @throws NotFoundException
     */
    public function find(string $id): AdminRole;
}
