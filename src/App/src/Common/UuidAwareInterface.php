<?php

declare(strict_types=1);

namespace Frontend\App\Common;

use Ramsey\Uuid\UuidInterface;

/**
 * Interface UuidAwareInterface
 * @package Frontend\App\Common
 */
interface UuidAwareInterface
{
    public function getUuid(): UuidInterface;
}
