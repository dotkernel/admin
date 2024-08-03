<?php

declare(strict_types=1);

namespace Admin\App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\MappedSuperclass]
abstract class AbstractEntity
{
    #[ORM\Id]
    #[ORM\Column(name: 'uuid', type: "uuid_binary", unique: true)]
    protected UuidInterface $uuid;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }
}
