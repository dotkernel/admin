<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 3/2/2017
 * Time: 7:39 PM
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
