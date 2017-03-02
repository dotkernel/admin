<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 3/2/2017
 * Time: 4:00 AM
 */

declare(strict_types = 1);

namespace Admin\Admin\Mapper;

/**
 * Class RoleDbMapper
 * @package Admin\Admin\Mapper
 */
class RoleDbMapper extends \Dot\User\Mapper\RoleDbMapper
{
    protected $table = 'admin_role';
}
