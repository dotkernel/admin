<?php

declare(strict_types=1);

namespace Frontend\App\Common;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidOrderedTimeGenerator as RamseyUuidOrderedTimeGenerator;
use Ramsey\Uuid\UuidInterface;

trait UuidAwareTrait
{
    #[ORM\Id]
    #[ORM\Column(name: 'uuid', type: "uuid_binary_ordered_time", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(RamseyUuidOrderedTimeGenerator::class)]
    protected ?UuidInterface $uuid = null;

    public function getUuid(): ?UuidInterface
    {
        if (! $this->uuid) {
            $this->uuid = UuidOrderedTimeGenerator::generateUuid();
        }

        return $this->uuid;
    }
}
