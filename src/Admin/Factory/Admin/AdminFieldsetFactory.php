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
use Dot\User\Options\UserOptions;
use Interop\Container\ContainerInterface;

/**
 * Class AdminFieldsetFactory
 * @package Dot\Authentication\Factory\Authentication
 */
class AdminFieldsetFactory
{
    /**
     * @param ContainerInterface $container
     * @return AdminFieldset
     */
    public function __invoke(ContainerInterface $container)
    {
        /** @var UserOptions $moduleOptions */
        $options = $container->get(UserOptions::class);

        $adminFieldset = new AdminFieldset();
        $adminFieldset->setHydrator($container->get($options->getUserEntityHydrator()));
        $adminFieldset->setObject($container->get($options->getUserEntity()));
        $adminFieldset->init();

        return $adminFieldset;
    }
}