<?php

declare(strict_types=1);

namespace AdminTest\Unit\Setting\Repository;

use AdminTest\Unit\UnitTest;
use Core\Setting\Entity\Setting;
use Core\Setting\Repository\SettingRepository;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SettingRepositoryTest extends UnitTest
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testWillCreate(): void
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getContainer()->get(EntityManager::class);

        $repository = new SettingRepository(
            $entityManager,
            $entityManager->getClassMetadata(Setting::class)
        );

        $this->assertSame(SettingRepository::class, $repository::class);
    }
}
