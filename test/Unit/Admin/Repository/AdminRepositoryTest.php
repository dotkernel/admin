<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\Repository;

use Doctrine\ORM\EntityManager;
use Frontend\Admin\Entity\Admin;
use Frontend\Admin\Repository\AdminRepository;
use FrontendTest\Unit\UnitTest;
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
