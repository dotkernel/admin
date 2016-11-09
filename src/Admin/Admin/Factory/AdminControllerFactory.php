<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/4/2016
 * Time: 7:45 PM
 */

namespace Dot\Admin\Admin\Factory;

use Dot\Admin\Admin\Controller\AdminController;
use Dot\Admin\Admin\Form\AdminForm;
use Dot\Admin\Admin\Service\AdminServiceInterface;
use Interop\Container\ContainerInterface;

/**
 * Class AdminControllerFactory
 * @package Dot\Admin\Admin\Factory
 */
class AdminControllerFactory
{
    /**
     * @param ContainerInterface $container
     * @return AdminController
     */
    public function __invoke(ContainerInterface $container)
    {
        return new AdminController(
            $container->get(AdminServiceInterface::class),
            $container->get(AdminForm::class)
        );
    }

}