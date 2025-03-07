<?php

declare(strict_types=1);

namespace Admin\Admin\DBAL\Types;

use Admin\Admin\Enum\AdminLoginStatusEnum;
use Admin\App\DBAL\Types\AbstractEnumType;

class AdminLoginStatusEnumType extends AbstractEnumType
{
    public const NAME = 'admin_login_status_enum';

    protected function getEnumClass(): string
    {
        return AdminLoginStatusEnum::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
