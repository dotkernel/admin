<?php

declare(strict_types=1);

namespace Admin\Admin\Enum;

enum AdminStatusEnum: string
{
    case Active   = 'active';
    case Inactive = 'pending';
}
