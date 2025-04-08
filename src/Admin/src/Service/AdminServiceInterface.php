<?php

declare(strict_types=1);

namespace Admin\Admin\Service;

use Core\Admin\Entity\Admin;
use Core\Admin\Repository\AdminRepository;
use Core\App\Exception\BadRequestException;
use Core\App\Exception\ConflictException;
use Core\App\Exception\NotFoundException;

interface AdminServiceInterface
{
    public function getAdminRepository(): AdminRepository;

    /**
     * @throws BadRequestException
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function createAdmin(array $data): Admin;

    public function deleteAdmin(Admin $admin): void;

    /**
     * @throws NotFoundException
     */
    public function find(string $uuid): Admin;

    /**
     * @param array<string, mixed> $params
     */
    public function getAdmins(array $params): array;

    /**
     * @throws BadRequestException
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function updateAdmin(Admin $admin, array $data): Admin;
}
