<?php

declare(strict_types=1);

namespace AdminTest\Unit\Setting\Repository;

use Admin\Setting\Entity\Setting;
use Admin\Setting\Repository\SettingRepository;
use AdminTest\Unit\UnitTest;
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

        $this->assertInstanceOf(SettingRepository::class, $repository);
    }
}
