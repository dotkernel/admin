<?php

declare(strict_types=1);

namespace Core\Admin\Service;

interface AdminRoleServiceInterface
{
    public function getRoles(): array;
}
