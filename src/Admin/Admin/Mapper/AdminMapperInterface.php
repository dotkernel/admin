<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/7/2016
 * Time: 11:00 PM
 */

namespace Dot\Admin\Admin\Mapper;

use Dot\User\Mapper\UserMapperInterface;


/**
 * Interface AdminMapperInterface
 * @package Dot\Admin\Admin\Mapper
 */
interface AdminMapperInterface extends UserMapperInterface
{
    /**
     * @param array $filters
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function findUsersPaginated(array $filters = [], $limit = 30, $offset = 0);
}