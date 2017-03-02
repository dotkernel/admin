<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/21/2016
 * Time: 10:09 PM
 */

namespace Admin\App\Service;

use Admin\App\Exception\RuntimeException;
use Dot\Ems\Mapper\MapperInterface;
use Dot\Ems\Mapper\MapperManagerAwareInterface;
use Dot\Ems\Mapper\MapperManagerAwareTrait;
use Dot\Paginator\Adapter\MapperAdapter;
use Zend\Paginator\Paginator;

/**
 * Class AbstractEntityService
 * @package Dot\Authentication\Service
 */
abstract class AbstractEntityService implements EntityServiceInterface, MapperManagerAwareInterface
{
    use MapperManagerAwareTrait;

    /** @var  string */
    protected $entityClass;

    /** @var  string */
    protected $paginatorClass = Paginator::class;

    /** @var string  */
    protected $entityIdentifier = 'id';

    /** @var  MapperInterface */
    protected $entityMapper;

    /**
     * @param $ids
     * @return int
     */
    public function markAsDeleted(array $ids): int
    {
        return $this->getEntityMapper()->updateAll(['status' => 'deleted'], [$this->entityIdentifier => $ids]);
    }

    /**
     * @param array $ids
     * @return int
     */
    public function deleteAll(array $ids): int
    {
        return $this->getEntityMapper()->deleteAll([$this->entityIdentifier => $ids]);
    }

    /**
     * @param $id
     * @param array $options
     * @return mixed|null
     */
    public function find($id, array $options = [])
    {
        return $this->getEntityMapper()->get($id, $options);
    }

    /**
     * @param array $options
     * @param bool $paginated
     * @return array|Paginator
     */
    public function findAll(array $options = [], bool $paginated = false)
    {
        if (!$paginated) {
            return $this->getEntityMapper()->find('all', $options);
        }

        //returns paginated results
        return $this->getPaginator($this->getEntityMapper(), $options);
    }

    /**
     * @param mixed $entity
     * @param array $options
     * @return mixed
     */
    public function save($entity, array $options = [])
    {
        return $this->getEntityMapper()->save($entity, $options);
    }

    /**
     * @param mixed $entity
     * @param array $options
     * @return mixed
     */
    public function delete($entity, array $options = [])
    {
        return $this->getEntityMapper()->delete($entity, $options);
    }

    /**
     * @return MapperInterface
     */
    public function getEntityMapper(): MapperInterface
    {
        if (!$this->entityMapper) {
            $this->entityMapper = $this->getMapperManager()->get($this->entityClass);
        }

        return $this->entityMapper;
    }

    /**
     * @param MapperInterface $mapper
     * @param array $options
     * @return Paginator
     */
    public function getPaginator(MapperInterface $mapper, array $options = []): Paginator
    {
        if (!class_exists($this->paginatorClass)) {
            throw new RuntimeException(sprintf('Paginator class %s does not exists', $this->paginatorClass));
        }

        $class = $this->paginatorClass;
        return new $class(new MapperAdapter($mapper, $options));
    }
}
