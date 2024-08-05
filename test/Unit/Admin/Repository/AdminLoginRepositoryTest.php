<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Repository;

use Admin\Admin\Entity\AdminLogin;
use Admin\Admin\Repository\AdminLoginRepository;
use AdminTest\Unit\UnitTest;
use Doctrine\ORM\EntityManager;
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
