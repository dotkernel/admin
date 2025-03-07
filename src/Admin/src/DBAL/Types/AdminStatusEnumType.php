<?php

declare(strict_types=1);

namespace Admin\Admin\DBAL\Types;

use Admin\Admin\Enum\AdminStatusEnum;
use Admin\App\DBAL\Types\AbstractEnumType;

class AdminStatusEnumType extends AbstractEnumType
{
    public const NAME = 'admin_status_enum';

    protected function getEnumClass(): string
    {
        return AdminStatusEnum::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
