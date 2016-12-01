<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/10/2016
 * Time: 9:10 PM
 */

namespace Dot\Admin\Factory\Admin;

use Dot\Admin\Form\Admin\AdminFieldset;
use Dot\User\Entity\UserEntityInterface;
use Dot\User\Options\UserOptions;
use Interop\Container\ContainerInterface;
use Zend\Hydrator\ClassMethods;
use Zend\Hydrator\HydratorInterface;

/**
 * Class AdminFieldsetFactory
 * @package Dot\Authentication\Factory\Authentication
 */
class AdminFieldsetFactory
{
    /**
     * @param ContainerInterface $container
     * @return AdminFieldset
     * @throws \Exception
     */
    public function __invoke(ContainerInterface $container)
    {
        /** @var UserOptions $moduleOptions */
        $options = $container->get(UserOptions::class);

        $prototype = $options->getUserEntity();
        if($container->has($prototype)) {
            $prototype = $container->get($prototype);
        }

        if(is_string($prototype) && class_exists($prototype)) {
            $prototype = new $prototype;
        }

        if(!$prototype instanceof UserEntityInterface) {
            throw new \Exception('User entity prototype not valid');
        }

        if(!$options->getUserEntityHydrator()) {
            $hydrator = new ClassMethods(false);
        }
        else {
            $hydrator = $options->getUserEntityHydrator();
            if($container->has($hydrator)) {
                $hydrator = $container->get($hydrator);
            }

            if(is_string($hydrator) && class_exists($hydrator)) {
                $hydrator = new $hydrator;
            }

            if(!$hydrator instanceof HydratorInterface) {
                throw new \Exception('Invalid user entity hydrator');
            }
        }

        $adminFieldset = new AdminFieldset();
        $adminFieldset->setObject($prototype);
        $adminFieldset->setHydrator($hydrator);
        $adminFieldset->init();

        return $adminFieldset;
    }
}