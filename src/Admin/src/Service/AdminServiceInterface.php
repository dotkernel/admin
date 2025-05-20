<?php

declare(strict_types=1);

namespace Admin\Admin\Service;

use Admin\Admin\InputFilter\ChangePasswordInputFilter;
use Admin\Admin\InputFilter\CreateAdminInputFilter;
use Admin\Admin\InputFilter\EditAccountInputFilter;
use Admin\App\Exception\BadRequestException;
use Admin\App\Exception\ConflictException;
use Admin\App\Exception\NotFoundException;
use Core\Admin\Entity\Admin;
use Core\Admin\Repository\AdminRepository;

/**
 * @phpstan-import-type CreateAdminDataType from CreateAdminInputFilter
 * @phpstan-import-type EditAccountDataType from EditAccountInputFilter
 * @phpstan-import-type ChangePasswordDataType from ChangePasswordInputFilter
 */
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
     * @return array<non-empty-string, mixed>
     */
    public function getAdmins(array $params): array;

    /**
     * @phpstan-param CreateAdminDataType|EditAccountDataType|ChangePasswordDataType $data
     * @throws BadRequestException
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function saveAdmin(array $data, ?Admin $admin = null): Admin;
}
