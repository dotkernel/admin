<?php

namespace Frontend\Admin\Entity;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class EnumAdminStatus extends Type
{
    const NAME = 'admin-enum-status';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return "ENUM(".implode(", ", $fieldDeclaration["values"])
            . ") DEFAULT '" . $fieldDeclaration["default"] . "'";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}