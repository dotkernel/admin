<?php

declare(strict_types=1);

namespace Frontend\App\Entity;

use DateTimeImmutable;
use Frontend\App\Common\TimestampAwareInterface;
use Frontend\App\Common\TimestampAwareTrait;
use Frontend\App\Common\UuidAwareInterface;
use Frontend\App\Common\UuidAwareTrait;
use Frontend\App\Common\UuidOrderedTimeGenerator;

abstract class AbstractEntity implements UuidAwareInterface, TimestampAwareInterface
{
    use TimestampAwareTrait;
    use UuidAwareTrait;

    public function __construct()
    {
        $this->uuid    = UuidOrderedTimeGenerator::generateUuid();
        $this->created = new DateTimeImmutable();
        $this->updated = new DateTimeImmutable();
    }
}
