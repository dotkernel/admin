<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 1/26/2017
 * Time: 3:07 AM
 */

namespace Dot\Admin\Mapper;

use Dot\Ems\Mapper\MapperInterface;

/**
 * Interface EntityMapperInterface
 * @package Dot\Admin\Mapper
 */
interface EntityMapperInterface extends MapperInterface
{
    /**
     * @param $fieldName
     * @param string $deletedValue
     * @param $ids
     * @return mixed
     */
    public function markAsDeleted(array $ids, $fieldName, $deletedValue = 'deleted');

    /**
     * @param $ids
     * @return mixed
     */
    public function bulkDelete(array $ids);
}
