<?php

declare(strict_types=1);

namespace Frontend\App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;

use function is_array;

/**
 * @extends EntityRepository<object>
 */
abstract class AbstractRepository extends EntityRepository
{
    public function getQueryBuilder(): QueryBuilder
    {
        return $this->getEntityManager()->createQueryBuilder();
    }

    /**
     * @param mixed $id
     * @param int|null $lockMode
     * @param int|null $lockVersion
     * @throws NonUniqueResultException
     */
    public function find($id, $lockMode = null, $lockVersion = null): ?object
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('entity')
            ->from($this->getEntityName(), 'entity')
            ->where('entity.uuid = :uuid');

        if (is_array($id)) {
            $qb->setParameter('uuid', $id['uuid']->getBytes());
        } else {
            $qb->setParameter('uuid', $id, UuidBinaryOrderedTimeType::NAME);
        }

        return $qb->getQuery()->getOneOrNullResult();
    }
}
