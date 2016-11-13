<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/6/2016
 * Time: 9:37 PM
 */

namespace Dot\Admin\Admin\Service;

use Dot\Admin\Admin\Entity\AdminEntity;

/**
 * Interface AdminServiceInterface
 * @package Dot\Admin\Admin\Service
 */
interface AdminServiceInterface
{
    /**
     * @param array $filters
     * @return mixed
     */
    public function getAdmins(array $filters = []);

    /**
     * @param array $filters
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function getAdminsPaginated(array $filters = [], $limit = 30, $offset = 0);

    /**
     * @param AdminEntity $admin
     * @return mixed
     */
    public function saveAdmin(AdminEntity $admin);

    /**
     * @param $id
     * @return mixed
     */
    public function getAdminById($id);

    /**
     * @param $id
     * @param bool $markAsDeleted
     * @return mixed
     */
    public function deleteAdminsById($id, $markAsDeleted = true);
}