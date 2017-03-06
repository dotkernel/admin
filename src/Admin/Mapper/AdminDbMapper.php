<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 2/28/2017
 * Time: 4:21 PM
 */

declare(strict_types = 1);

namespace Admin\Admin\Mapper;

use Admin\App\Mapper\SearchFinderMapperTrait;
use Dot\User\Mapper\UserDbMapper;

/**
 * Class AdminDbMapper
 * @package App\Admin\Mapper
 */
class AdminDbMapper extends UserDbMapper
{
    use SearchFinderMapperTrait;

    /** @var string  */
    protected $table = 'admin';

    /** @var string  */
    protected $rolesIntersectionTable = 'admin_roles';
}
