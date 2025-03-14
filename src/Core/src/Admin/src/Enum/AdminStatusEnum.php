<?php

declare(strict_types=1);

namespace Core\Admin\Enum;

use function array_column;

enum AdminStatusEnum: string
{
    case Active   = 'active';
    case Inactive = 'inactive';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
