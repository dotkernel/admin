<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vra
 * Date: 11/6/2016
 * Time: 9:50 PM
 */

namespace Dot\Admin\Factory\Admin;

use Dot\Admin\Entity\AdminEntity;
use Dot\Admin\Entity\AdminEntityHydrator;
use Dot\Admin\Mapper\EntityOperationsDbMapper;
use Dot\Admin\Service\AdminService;
use Dot\Ems\Mapper\DbMapper;
use Interop\Container\ContainerInterface;
use Zend\Crypt\Password\PasswordInterface;
use Zend\Paginator\AdapterPluginManager;

/**
 * Class AdminServiceFactory
 * @package Dot\Authentication\Authentication\Factory
 */
class AdminServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return AdminService
     */
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('database');
        $paginatorAdapterManager = $container->get(AdapterPluginManager::class);

        $adminMapper = new DbMapper('admin', $dbAdapter, new AdminEntity(), new AdminEntityHydrator());
        $adminMapper->setPaginatorAdapterManager($paginatorAdapterManager);

        $service = new AdminService($adminMapper);
        $entityOperationsMapper = new EntityOperationsDbMapper('admin', $dbAdapter);
        $service->setEntityOperationsMapper($entityOperationsMapper);

        $service->setPasswordService($container->get(PasswordInterface::class));

        return $service;
    }
}