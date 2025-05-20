<?php

declare(strict_types=1);

namespace AdminTest\Unit\App\Entity;

use AdminTest\Unit\UnitTest;
use Core\App\Entity\AbstractEntity;
use Core\App\Entity\EntityInterface;
use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

class AbstractEntityTest extends UnitTest
{
    public function testWillInstantiate(): void
    {
        $entity = new class extends AbstractEntity {
            /**
             * @return array<string, mixed>
             */
            public function getArrayCopy(): array
            {
                return [];
            }

            public function getCreated(): ?DateTimeImmutable
            {
                return null;
            }

            public function getCreatedFormatted(string $dateFormat = 'Y-m-d H:i:s'): string
            {
                return '';
            }

            public function getUpdated(): ?DateTimeImmutable
            {
                return null;
            }

            public function getUpdatedFormatted(string $dateFormat = 'Y-m-d H:i:s'): ?string
            {
                return null;
            }
        };

        $this->assertContainsOnlyInstancesOf(EntityInterface::class, [$entity]);
        $this->assertContainsOnlyInstancesOf(UuidInterface::class, [$entity->getUuid()]);
    }
}
