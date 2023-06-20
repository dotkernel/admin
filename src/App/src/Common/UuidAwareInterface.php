<?php

declare(strict_types=1);

namespace Frontend\App\Common;

use Ramsey\Uuid\UuidInterface;

/**
 * Interface UuidAwareInterface
 */
interface UuidAwareInterface
{
    public function getUuid(): ?UuidInterface;
}
