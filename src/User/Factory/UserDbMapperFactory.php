<?php
/**
 * @see https://github.com/dotkernel/dot-admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-admin/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Admin\User\Factory;

use Admin\User\Entity\UserEntity;
use Dot\Mapper\Factory\DbMapperFactory;
use Dot\User\Entity\RoleEntity;
use Dot\User\Options\UserOptions;
use Interop\Container\ContainerInterface;

/**
 * Class UserDbMapperFactory
 * @package Admin\User\Factory
 */
class UserDbMapperFactory extends DbMapperFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        if ($options === null) {
            $options = [];
        }

        /** @var UserOptions $userOptions */
        $userOptions = $container->get(UserOptions::class);
        $userOptions = clone $userOptions;
        $userOptions->setUserEntity(UserEntity::class);
        $userOptions->setRoleEntity(RoleEntity::class);
        $userOptions->setDefaultRoles(['user']);

        $options['user_options'] = $userOptions;

        return parent::__invoke($container, $requestedName, $options);
    }
}
