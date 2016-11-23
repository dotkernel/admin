<?php
/**
 * @copyright: DotKernel
 * @package: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/20/2016
 * Time: 12:10 PM
 */

namespace Dot\Admin\Factory\User;

use Dot\Admin\Entity\UserDetailsEntity;
use Dot\Admin\Entity\UserEntity;
use Dot\Admin\Mapper\EntityOperationsDbMapper;
use Dot\Admin\Service\UserService;
use Dot\Ems\Mapper\DbMapper;
use Dot\Ems\Mapper\Relation\OneToOneRelation;
use Dot\Ems\Mapper\RelationalDbMapper;
use Dot\Ems\Service\EntityService;
use Interop\Container\ContainerInterface;
use Zend\Crypt\Password\PasswordInterface;
use Zend\Hydrator\ClassMethods;
use Zend\Paginator\AdapterPluginManager;

/**
 * Class UserServiceFactory
 * @package Dot\Authentication\Factory\User
 */
class UserServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return EntityService
     */
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('database');
        $paginatorAdapterManager = $container->get(AdapterPluginManager::class);

        $userMapper = new RelationalDbMapper('user', $dbAdapter, new UserEntity(), new ClassMethods(false));
        $userMapper->setPaginatorAdapterManager($paginatorAdapterManager);

        $userDetailsMapper = new DbMapper('user_details', $dbAdapter, new UserDetailsEntity());
        $userDetailsMapper->setIdentifierName('userId');
        $userDetailsMapper->setPaginatorAdapterManager($paginatorAdapterManager);

        $relation = new OneToOneRelation($userDetailsMapper, 'userId');
        $userMapper->addRelation('details', $relation);

        $service = new UserService($userMapper);
        $entityOperationsMapper = new EntityOperationsDbMapper('user', $dbAdapter);
        $service->setEntityOperationsMapper($entityOperationsMapper);

        $service->setPasswordService($container->get(PasswordInterface::class));

        return $service;
    }
}