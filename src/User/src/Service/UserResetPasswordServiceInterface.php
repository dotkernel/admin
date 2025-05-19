<?php

declare(strict_types=1);

namespace Admin\User\Service;

use Admin\App\Exception\NotFoundException;
use Core\User\Entity\UserResetPassword;
use Core\User\Repository\UserResetPasswordRepository;

interface UserResetPasswordServiceInterface
{
    public function getUserResetPasswordRepository(): UserResetPasswordRepository;

    /**
     * @param non-empty-array<non-empty-string, mixed> $params
     * @throws NotFoundException
     */
    public function findOneBy(array $params): UserResetPassword;
}
