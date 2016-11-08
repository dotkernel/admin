<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/8/2016
 * Time: 12:19 AM
 */

namespace Dot\Admin\Admin\Factory;

use Dot\Admin\Admin\Mapper\AdminDbMapper;
use Dot\User\Options\UserOptions;
use Interop\Container\ContainerInterface;
use Zend\Db\ResultSet\HydratingResultSet;

class AdminDbMapperFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var UserOptions $options */
        $options = $container->get(UserOptions::class);
        $dbAdapter = $container->get($options->getDbOptions()->getDbAdapter());

        $resultSetPrototype = new HydratingResultSet(
            $container->get($options->getUserEntityHydrator()),
            $container->get($options->getUserEntity()));

        $mapper = new AdminDbMapper(
            $options->getDbOptions()->getUserTable(),
            $options->getDbOptions(),
            $dbAdapter,
            null,
            $resultSetPrototype);

        return $mapper;
    }
}