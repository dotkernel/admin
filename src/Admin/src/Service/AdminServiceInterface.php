<?php

declare(strict_types=1);

namespace Admin\Admin\Service;

use Admin\App\Exception\BadRequestException;
use Admin\App\Exception\ConflictException;
use Admin\App\Exception\NotFoundException;
use Core\Admin\Entity\Admin;
use Core\Admin\Repository\AdminRepository;

interface AdminServiceInterface
{
    public function getAdminRepository(): AdminRepository;

    public function deleteAdmin(Admin $admin): void;

    /**
     * @throws NotFoundException
     */
    public function findAdmin(string $uuid): Admin;

    /**
     * @param array<string, mixed> $params
     */
    public function getAdmins(array $params): array;

    /**
     * @throws BadRequestException
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function saveAdmin(array $data, ?Admin $admin = null): Admin;
}
