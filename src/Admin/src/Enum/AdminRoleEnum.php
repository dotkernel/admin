<?php

declare(strict_types=1);

namespace Admin\Admin\Enum;

enum AdminRoleEnum: string
{
    case Admin     = 'admin';
    case Superuser = 'superuser';
}
