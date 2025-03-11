<?php

declare(strict_types=1);

namespace Admin\Admin\DBAL\Types;

use Admin\Admin\Enum\YesNoEnum;
use Admin\App\DBAL\Types\AbstractEnumType;

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
