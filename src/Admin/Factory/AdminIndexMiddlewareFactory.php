<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/7/2016
 * Time: 7:55 PM
 */

namespace Dot\Admin\Factory;


use Dot\Admin\Middleware\AdminIndexMiddleware;
use Dot\Authentication\AuthenticationInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;

/**
 * Class AdminIndexMiddlewareFactory
 * @package Dot\Authentication\Factory
 */
class AdminIndexMiddlewareFactory
{
    /**
     * @param ContainerInterface $container
     * @return AdminIndexMiddleware
     */
    public function __invoke(ContainerInterface $container)
    {
        return new AdminIndexMiddleware(
            $container->get(AuthenticationInterface::class),
            $container->get(UrlHelper::class)
        );
    }
}