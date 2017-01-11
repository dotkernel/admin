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
use Dot\Helpers\DependencyHelperTrait;
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
    use DependencyHelperTrait;

    /**
     * @param ContainerInterface $container
     * @return AdminFieldset
     * @throws \Exception
     */
    public function __invoke(ContainerInterface $container)
    {
        /** @var UserOptions $moduleOptions */
        $options = $container->get(UserOptions::class);

        $prototype = $this->getDependencyObject($container, $options->getUserEntity());
        if (!$prototype instanceof UserEntityInterface) {
            throw new \Exception('User entity prototype not valid');
        }
        $hydrator = $this->getDependencyObject($container, $options->getUserEntityHydrator());
        if (!$hydrator instanceof HydratorInterface) {
            $hydrator = new ClassMethods(false);
        }

        $adminFieldset = new AdminFieldset();
        $adminFieldset->setObject($prototype);
        $adminFieldset->setHydrator($hydrator);
        $adminFieldset->init();

        return $adminFieldset;
    }
}
