<?php

declare(strict_types=1);

namespace AdminTest\Unit\App\Repository;

use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\Admin;
use Core\App\Repository\AbstractRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class AbstractRepositoryTest extends UnitTest
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testWillInstantiate(): void
    {
        $entityManager = $this->getEntityManager();
        $classMetadata = $entityManager->getClassMetadata(Admin::class);

        $repository = new class ($entityManager, $classMetadata) extends AbstractRepository {
        };

        $this->assertInstanceOf(AbstractRepository::class, $repository);
        $this->assertInstanceOf(EntityRepository::class, $repository);
        $this->assertInstanceOf(QueryBuilder::class, $repository->getQueryBuilder());
    }
}
