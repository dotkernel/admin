<?php

declare(strict_types=1);

namespace Admin\Admin\Service;

use Core\Admin\Entity\AdminLogin;
use Core\Admin\Repository\AdminLoginRepository;
use Exception;

interface AdminLoginServiceInterface
{
    public function getAdminLoginRepository(): AdminLoginRepository;

    /**
     * @param array<non-empty-string, mixed> $params
     * @return array<non-empty-string, mixed>
     */
    public function getAdminLogins(array $params): array;

    /**
     * @param non-empty-array<non-empty-string, mixed> $serverParams
     * @throws Exception
     */
    public function logFailedLogin(array $serverParams, string $name): AdminLogin;

    /**
     * @param non-empty-array<non-empty-string, mixed> $serverParams
     * @throws Exception
     */
    public function logSuccessfulLogin(array $serverParams, string $name): AdminLogin;
}
