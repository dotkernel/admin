<?php

declare(strict_types=1);

namespace Admin\Admin\DBAL\Types;

use Admin\Admin\Enum\AdminIsMobileEnum;
use Admin\App\DBAL\Types\AbstractEnumType;

class AdminIsMobileEnumType extends AbstractEnumType
{
    public const NAME = 'admin_is_mobile_enum';

    protected function getEnumClass(): string
    {
        return AdminIsMobileEnum::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
