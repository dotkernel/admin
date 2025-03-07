<?php

declare(strict_types=1);

namespace Admin\Admin\DBAL\Types;

use Admin\Admin\Enum\AdminRoleEnum;
use Admin\App\DBAL\Types\AbstractEnumType;

class AdminRoleEnumType extends AbstractEnumType
{
    public const NAME = 'admin_role_enum';

    protected function getEnumClass(): string
    {
        return AdminRoleEnum::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
