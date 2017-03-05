<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 3/2/2017
 * Time: 7:42 PM
 */

declare(strict_types = 1);

namespace Admin\User\Factory;

use Admin\User\Entity\UserEntity;
use Dot\Hydrator\ClassMethodsCamelCase;
use Dot\User\Entity\RoleEntity;
use Dot\User\Form\UserFieldset;
use Interop\Container\ContainerInterface;
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
