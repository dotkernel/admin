<?php

declare(strict_types=1);

namespace AdminTest\Unit\App\Entity;

use AdminTest\Unit\UnitTest;
use Core\App\Entity\AbstractEntity;
use Ramsey\Uuid\UuidInterface;

class AbstractEntityTest extends UnitTest
{
    public function testWillInstantiate(): void
    {
        $entity = new class extends AbstractEntity {
        };

        $this->assertInstanceOf(AbstractEntity::class, $entity);
        $this->assertInstanceOf(UuidInterface::class, $entity->getUuid());
    }
}
