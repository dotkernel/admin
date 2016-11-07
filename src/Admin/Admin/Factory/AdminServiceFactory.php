<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vra
 * Date: 11/6/2016
 * Time: 9:50 PM
 */

namespace Dot\Admin\Admin\Factory;


use Dot\Admin\Admin\Service\AdminService;
use Dot\User\Mapper\UserMapperInterface;
use Interop\Container\ContainerInterface;

/**
 * Class AdminServiceFactory
 * @package Dot\Admin\Admin\Factory
 */
class AdminServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return AdminService
     */
    public function __invoke(ContainerInterface $container)
    {
        return new AdminService($container->get(UserMapperInterface::class));
    }
}