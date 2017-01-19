<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin.
 * @author: n3vrax
 * Date: 1/14/2017
 * Time: 12:09 AM
 */

namespace Dot\Admin\Factory;

use Dot\Admin\Service\Listener\AdminServiceListener;
use Dot\Authentication\AuthenticationInterface;
use Interop\Container\ContainerInterface;

/**
 * Class AdminServiceListenerFactory
 * @package Dot\Admin\Factory
 */
class AdminServiceListenerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AdminServiceListener(
            $container->get('action_logger'),
            $container->get(AuthenticationInterface::class)
        );
    }
}
