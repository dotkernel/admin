<?php

declare(strict_types=1);

namespace FrontendTest\Unit\App\Entity;

use DateTimeInterface;
use Frontend\App\Entity\AbstractEntity;
use FrontendTest\Unit\UnitTest;
use Ramsey\Uuid\UuidInterface;

class AbstractEntityTest extends UnitTest
{
    public function testWillInstantiate(): void
    {
        $entity = new class extends AbstractEntity {
        };

        $this->assertInstanceOf(AbstractEntity::class, $entity);
        $this->assertInstanceOf(UuidInterface::class, $entity->getUuid());
        $this->assertInstanceOf(DateTimeInterface::class, $entity->getCreated());
        $this->assertInstanceOf(DateTimeInterface::class, $entity->getUpdated());
    }
}
