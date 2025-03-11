<?php

declare(strict_types=1);

namespace Admin\Admin\DBAL\Types;

use Admin\Admin\Enum\SuccessFailureEnum;
use Admin\App\DBAL\Types\AbstractEnumType;

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
