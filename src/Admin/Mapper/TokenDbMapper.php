<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 3/7/2017
 * Time: 9:47 PM
 */

declare(strict_types = 1);

namespace Admin\Admin\Mapper;

/**
 * Class TokenDbMapper
 * @package Admin\Admin\Mapper
 */
class TokenDbMapper extends \Dot\User\Mapper\TokenDbMapper
{
    /** @var string  */
    protected $table = 'admin_token';
}
