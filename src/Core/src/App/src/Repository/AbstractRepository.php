<?php

declare(strict_types=1);

namespace Core\App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends EntityRepository<object>
 */
abstract class AbstractRepository extends EntityRepository
{
    public function getQueryBuilder(): QueryBuilder
    {
        return $this->getEntityManager()->createQueryBuilder();
    }
}
