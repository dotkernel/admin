<?php
/**
 * @see https://github.com/dotkernel/admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/admin/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Admin\User\Factory;

use Admin\User\Entity\UserEntity;
use Dot\User\Entity\RoleEntity;
use Dot\User\Form\UserFieldset;
use Psr\Container\ContainerInterface;
use Zend\Hydrator\HydratorPluginManager;

/**
 * Class UserFieldsetFactory
 * @package Admin\User\Factory
 */
class UserFieldsetFactory extends \Dot\User\Factory\UserFieldsetFactory
{
    /**
     * @param ContainerInterface $container
     * @param $requestedName
     * @return UserFieldset
     */
    public function __invoke(ContainerInterface $container, $requestedName): UserFieldset
    {
        $fieldset = parent::__invoke($container, $requestedName);
        $userOptions = $fieldset->getUserOptions();
        $userOptions = clone $userOptions;

        $userOptions->setUserEntity(UserEntity::class);
        $userOptions->setRoleEntity(RoleEntity::class);
        $userOptions->setDefaultRoles(['user']);

        /** @var HydratorPluginManager $hydratorManager */
        $hydratorManager = $container->get('HydratorManager');
        $entity = new UserEntity();

        $fieldset->setUserOptions($userOptions);
        $fieldset->setObject($entity);
        $fieldset->setHydrator($hydratorManager->get($entity->hydrator()));

        return $fieldset;
    }
}
