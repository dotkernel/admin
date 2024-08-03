<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Repository;

use Admin\Admin\Entity\AdminRole;
use Admin\Admin\Repository\AdminRoleRepository;
use AdminTest\Unit\UnitTest;
use Doctrine\ORM\EntityManager;
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
