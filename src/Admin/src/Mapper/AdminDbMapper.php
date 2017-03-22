<?php
/**
 * @see https://github.com/dotkernel/dot-admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-admin/blob/master/LICENSE.md MIT License
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
