<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Setting\Repository;

use Doctrine\ORM\EntityManager;
use Frontend\Setting\Entity\Setting;
use Frontend\Setting\Repository\SettingRepository;
use FrontendTest\Unit\UnitTest;
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
