<?php

declare(strict_types=1);

namespace Frontend\App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;

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

    /**
     * @param mixed $uuid
     * @param null $lockMode
     * @param null $lockVersion
     * @return int|mixed|object|string|null
     * @throws NonUniqueResultException
     */
    public function find($uuid, $lockMode = null, $lockVersion = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('entity')
            ->from($this->getEntityName(), 'entity')
            ->where('entity.uuid = :uuid');

        if (is_array($uuid)) {
            $qb->setParameter('uuid', $uuid['uuid']->getBytes());
        } else {
            $qb->setParameter('uuid', $uuid, UuidBinaryOrderedTimeType::NAME);
        }

        return $qb->getQuery()->getOneOrNullResult();
    }
}
