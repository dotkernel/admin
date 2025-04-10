<?php

declare(strict_types=1);

namespace AdminTest\Unit\App\Entity;

use AdminTest\Unit\UnitTest;
use Core\App\Entity\AbstractEntity;
use Core\App\Entity\EntityInterface;
use Ramsey\Uuid\UuidInterface;

class AbstractEntityTest extends UnitTest
{
    public function testWillInstantiate(): void
    {
        $entity = new class extends AbstractEntity {
            public function getArrayCopy(): array
            {
                return [];
            }
        };

        $this->assertContainsOnlyInstancesOf(EntityInterface::class, [$entity]);
        $this->assertContainsOnlyInstancesOf(UuidInterface::class, [$entity->getUuid()]);
    }
}
