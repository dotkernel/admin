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
     * @param array<string, mixed> $params
     */
    public function getAdminLogins(array $params): array;

    /**
     * @throws Exception
     */
    public function logFailedLogin(array $serverParams, string $name): AdminLogin;

    /**
     * @throws Exception
     */
    public function logSuccessfulLogin(array $serverParams, string $name): AdminLogin;
}
