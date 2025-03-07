<?php

declare(strict_types=1);

namespace Admin\Setting\DBAL\Types;

use Admin\App\DBAL\Types\AbstractEnumType;
use Admin\Setting\Enum\SettingEnum;

class SettingEnumType extends AbstractEnumType
{
    public const NAME = 'setting_enum';

    protected function getEnumClass(): string
    {
        return SettingEnum::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
