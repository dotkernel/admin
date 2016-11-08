<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/6/2016
 * Time: 9:37 PM
 */

namespace Dot\Admin\Admin\Service;

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
}