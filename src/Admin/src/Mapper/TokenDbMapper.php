<?php
/**
 * @see https://github.com/dotkernel/admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/admin/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace Admin\Admin\Mapper;

/**
 * Class TokenDbMapper
 * @package Admin\Admin\Mapper
 */
class TokenDbMapper extends \Dot\User\Mapper\TokenDbMapper
{
    /** @var string */
    protected $table = 'admin_token';
}
