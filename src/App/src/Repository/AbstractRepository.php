<?php

declare(strict_types=1);

namespace Frontend\App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class AbstractRepository
 * @package Frontend\App\Repository
 */
abstract class AbstractRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder(): QueryBuilder
    {
        return $this->getEntityManager()->createQueryBuilder();
    }
}
