<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\Repository;

use Doctrine\ORM\EntityManager;
use Frontend\Admin\Entity\AdminLogin;
use Frontend\Admin\Repository\AdminLoginRepository;
use FrontendTest\Unit\UnitTest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class AdminLoginRepositoryTest extends UnitTest
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testWillCreate(): void
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getContainer()->get(EntityManager::class);

        $repository = new AdminLoginRepository(
            $entityManager,
            $entityManager->getClassMetadata(AdminLogin::class)
        );

        $this->assertInstanceOf(AdminLoginRepository::class, $repository);
    }
}
