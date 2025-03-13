<?php

declare(strict_types=1);

namespace Core\Admin\DBAL\Types;

use Core\Admin\Enum\SuccessFailureEnum;
use Core\App\DBAL\Types\AbstractEnumType;

class SuccessFailureEnumType extends AbstractEnumType
{
    public const NAME = 'success_failure_enum';

    protected function getEnumClass(): string
    {
        return SuccessFailureEnum::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
