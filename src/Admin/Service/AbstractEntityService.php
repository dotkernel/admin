<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/21/2016
 * Time: 10:09 PM
 */

namespace Dot\Admin\Service;

use Dot\Admin\Mapper\EntityMapperInterface;
use Dot\Ems\Service\EntityService;

/**
 * Class AbstractEntityService
 * @package Dot\Authentication\Service
 */
abstract class AbstractEntityService extends EntityService implements EntityServiceInterface
{
    /** @var  EntityMapperInterface */
    protected $mapper;

    /**
     * @param $ids
     * @return mixed
     */
    public function markAsDeleted($ids)
    {
        return $this->mapper->markAsDeleted($ids, 'status', 'deleted');
    }

    /**
     * @param array $ids
     * @return mixed
     */
    public function bulkDelete($ids)
    {
        return $this->mapper->bulkDelete($ids);
    }
}
