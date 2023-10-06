<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\Repository;

use Doctrine\ORM\EntityManager;
use Frontend\Admin\Entity\AdminRole;
use Frontend\Admin\Repository\AdminRoleRepository;
use FrontendTest\Unit\UnitTest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class AdminRoleRepositoryTest extends UnitTest
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testWillCreate(): void
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getContainer()->get(EntityManager::class);

        $repository = new AdminRoleRepository(
            $entityManager,
            $entityManager->getClassMetadata(AdminRole::class)
        );

        $this->assertInstanceOf(AdminRoleRepository::class, $repository);
    }
}
