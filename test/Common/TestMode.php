<?php

declare(strict_types=1);

namespace FrontendTest\Common;

use function getenv;
use function putenv;

class TestMode
{
    public static function enable(): void
    {
        putenv('TEST_MODE=true');
    }

    public static function disable(): void
    {
        putenv('TEST_MODE');
    }

    public static function isEnabled(): bool
    {
        return getenv('TEST_MODE') === 'true';
    }
}
