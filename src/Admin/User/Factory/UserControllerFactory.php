<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/18/2016
 * Time: 9:24 PM
 */

namespace Dot\Admin\User\Factory;

use Dot\Admin\User\Controller\UserController;
use Dot\Admin\User\Entity\UserDetailsEntity;
use Dot\Admin\User\Entity\UserEntity;
use Dot\Ems\Mapper\DbMapper;
use Dot\Ems\Mapper\Relation\OneToOneRelation;
use Dot\Ems\Mapper\RelationalDbMapper;
use Dot\Ems\Service\EntityService;
use Dot\User\Entity\UserEntityHydrator;
use Interop\Container\ContainerInterface;
use Zend\Paginator\AdapterPluginManager;

/**
 * Class UserControllerFactory
 * @package Dot\Admin\User\Factory
 */
class UserControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('database');
        $paginatorAdapterManager = $container->get(AdapterPluginManager::class);

        $userMapper = new RelationalDbMapper('user', $dbAdapter, new UserEntity(), new UserEntityHydrator());
        $userMapper->setPaginatorAdapterManager($paginatorAdapterManager);

        $userDetailsMapper = new DbMapper('user_details', $dbAdapter, new UserDetailsEntity());
        $userDetailsMapper->setPaginatorAdapterManager($paginatorAdapterManager);

        $relation = new OneToOneRelation($userDetailsMapper, 'userId');
        $userMapper->addRelation('details', $relation);

        $service = new EntityService($userMapper);

        return new UserController($service);
    }
}