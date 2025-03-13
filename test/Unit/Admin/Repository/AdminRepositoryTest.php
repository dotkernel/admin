<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Repository;

use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\Admin;
use Core\Admin\Repository\AdminRepository;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class AdminRepositoryTest extends UnitTest
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testWillCreate(): void
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getContainer()->get(EntityManager::class);

        $repository = new AdminRepository(
            $entityManager,
            $entityManager->getClassMetadata(Admin::class)
        );

        $this->assertInstanceOf(AdminRepository::class, $repository);
    }
}
