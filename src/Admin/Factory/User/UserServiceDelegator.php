<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/30/2016
 * Time: 12:55 AM
 */

namespace Dot\Admin\Factory\User;

use Dot\Admin\Mapper\EntityOperationsDbMapper;
use Dot\Admin\Service\UserService;
use Interop\Container\ContainerInterface;
use Zend\Crypt\Password\PasswordInterface;
use Zend\ServiceManager\Factory\DelegatorFactoryInterface;

/**
 * Class UserServiceDelegator
 * @package Dot\Admin\Factory\User
 */
class UserServiceDelegator implements DelegatorFactoryInterface
{
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
        $service = $callback();
        if($service instanceof UserService) {
            $dbAdapter = $container->get('database');
            $entityOperationsMapper = new EntityOperationsDbMapper('user', $dbAdapter);
            $service->setEntityOperationsMapper($entityOperationsMapper);

            $service->setPasswordService($container->get(PasswordInterface::class));
        }

        return $service;
    }
}