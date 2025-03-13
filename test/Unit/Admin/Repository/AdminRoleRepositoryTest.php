<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Repository;

use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\AdminRole;
use Core\Admin\Repository\AdminRoleRepository;
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
