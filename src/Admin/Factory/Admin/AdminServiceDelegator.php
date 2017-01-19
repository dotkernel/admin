<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vra
 * Date: 11/6/2016
 * Time: 9:50 PM
 */

namespace Dot\Admin\Factory\Admin;

use Dot\Admin\Mapper\EntityOperationsDbMapper;
use Dot\Admin\Service\AdminService;
use Interop\Container\ContainerInterface;
use Zend\Crypt\Password\PasswordInterface;
use Zend\ServiceManager\Factory\DelegatorFactoryInterface;

/**
 * Class AdminServiceFactory
 * @package Dot\Authentication\Authentication\Factory
 */
class AdminServiceDelegator implements DelegatorFactoryInterface
{
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
        $service = $callback();
        if ($service instanceof AdminService) {
            $dbAdapter = $container->get('database');
            $entityOperationsMapper = new EntityOperationsDbMapper('admin', $dbAdapter);
            $service->setEntityOperationsMapper($entityOperationsMapper);

            $service->setPasswordService($container->get(PasswordInterface::class));
        }

        return $service;
    }
}
