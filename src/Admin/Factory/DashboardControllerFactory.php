<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 12/13/2016
 * Time: 7:34 PM
 */

namespace Dot\Admin\Factory;

use Dot\Admin\Controller\DashboardController;
use Interop\Container\ContainerInterface;

class DashboardControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new DashboardController();
    }
}
