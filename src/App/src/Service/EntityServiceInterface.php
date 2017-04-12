<?php
/**
 * @see https://github.com/dotkernel/admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/admin/blob/master/LICENSE.md MIT License
 */

namespace Admin\App\Service;

use Zend\Paginator\Paginator;

/**
 * Interface EntityServiceInterface
 * @package Admin\App\Service
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
