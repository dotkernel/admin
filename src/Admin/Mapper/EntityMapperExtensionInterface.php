<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/21/2016
 * Time: 9:28 PM
 */

namespace Dot\Admin\Mapper;

/**
 * Interface EntityMapperExtensionInterface
 * @package Dot\Admin\Mapper
 */
interface EntityMapperExtensionInterface
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