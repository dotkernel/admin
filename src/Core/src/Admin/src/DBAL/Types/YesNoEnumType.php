<?php

declare(strict_types=1);

namespace Core\Admin\DBAL\Types;

use Core\Admin\Enum\YesNoEnum;
use Core\App\DBAL\Types\AbstractEnumType;

class YesNoEnumType extends AbstractEnumType
{
    public const NAME = 'yes_no_enum';

    protected function getEnumClass(): string
    {
        return YesNoEnum::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
