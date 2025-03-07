<?php

declare(strict_types=1);

namespace Admin\Admin\Enum;

enum AdminLoginStatusEnum: string
{
    case Success = 'success';
    case Fail    = 'fail';
}
