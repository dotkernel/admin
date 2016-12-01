<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/21/2016
 * Time: 10:09 PM
 */

namespace Dot\Admin\Service;

use Dot\Admin\Mapper\EntityOperationsMapperInterface;
use Dot\Ems\Service\EntityService;

/**
 * Class AbstractEntityService
 * @package Dot\Authentication\Service
 */
abstract class AbstractEntityService extends EntityService implements EntityServiceInterface
{
    /** @var  EntityOperationsMapperInterface */
    protected $entityOperationsMapper;

    /**
     * @return EntityOperationsMapperInterface
     */
    public function getEntityOperationsMapper()
    {
        return $this->entityOperationsMapper;
    }

    /**
     * @param EntityOperationsMapperInterface $entityOperationsMapper
     * @return AbstractEntityService
     */
    public function setEntityOperationsMapper(EntityOperationsMapperInterface $entityOperationsMapper)
    {
        $this->entityOperationsMapper = $entityOperationsMapper;
        return $this;
    }

    /**
     * @param $ids
     * @return mixed
     */
    public function markAsDeleted($ids)
    {
        return $this->entityOperationsMapper->markAsDeleted($ids, 'status', 'deleted');
    }

    /**
     * @param array $ids
     * @return mixed
     */
    public function bulkDelete($ids)
    {
        return $this->entityOperationsMapper->bulkDelete($ids);
    }

}