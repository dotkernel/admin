<?php

declare(strict_types=1);

namespace Admin\App\Enum;

enum SuccessFailureEnum: string
{
    case Success = 'success';
    case Failure = 'failure';
}
