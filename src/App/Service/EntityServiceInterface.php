<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/21/2016
 * Time: 9:16 PM
 */

namespace Admin\User\Service;

use Zend\Paginator\Paginator;

/**
 * Interface EntityServiceInterface
 * @package Dot\Authentication\Service
 */
interface EntityServiceInterface
{
    /**
     * @param $ids
     * @return int
     */
    public function markAsDeleted(array $ids): int;

    /**
     * @param $ids
     * @return int
     */
    public function deleteAll(array $ids): int;

    /**
     * @param $id
     * @param array $options
     * @return mixed
     */
    public function find($id, array $options = []);

    /**
     * @param array $options
     * @param bool $paginated
     * @return array|Paginator
     */
    public function findAll(array $options = [], bool $paginated = false);

    /**
     * @param mixed $entity
     * @param array $options
     * @return mixed
     */
    public function save($entity, array $options = []);

    /**
     * @param mixed $entity
     * @param array $options
     * @return mixed
     */
    public function delete($entity, array $options = []);
}
