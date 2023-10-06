<?php

declare(strict_types=1);

namespace FrontendTest\Unit\App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Frontend\Admin\Entity\Admin;
use Frontend\App\Repository\AbstractRepository;
use FrontendTest\Unit\UnitTest;
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
