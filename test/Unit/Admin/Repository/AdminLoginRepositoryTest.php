<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Repository;

use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\AdminLogin;
use Core\Admin\Repository\AdminLoginRepository;
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
