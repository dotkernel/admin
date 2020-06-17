<?php

declare(strict_types=1);

namespace Frontend\App\Common;

/**
 * Class StaticContent
 * @package Frontend\App\Common
 */
class StaticContent
{
    public const GENERAL_UUID_REGEX = '[0-9A-Fa-f]{8}-?[0-9A-Fa-f]{4}-?[0-9A-Fa-f]{4}-?[0-9A-Fa-f]{4}-?[0-9A-Fa-f]{12}';

    public const UUID_REGEX = '{uuid:' . self::GENERAL_UUID_REGEX . '}';

    public const IMAGE_WIDTH = 500;
    public const IMAGE_HEIGHT = 500;
}
