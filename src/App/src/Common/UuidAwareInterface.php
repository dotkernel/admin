<?php

declare(strict_types=1);

namespace Frontend\App\Common;

use Ramsey\Uuid\UuidInterface;

interface UuidAwareInterface
{
    public function getUuid(): ?UuidInterface;
}
