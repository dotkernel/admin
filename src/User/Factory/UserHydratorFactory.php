<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 3/5/2017
 * Time: 3:01 AM
 */

declare(strict_types = 1);

namespace Admin\User\Factory;

use Admin\User\Hydrator\UserHydrator;
use Admin\User\Hydrator\RolesHydratingStrategy;
use Interop\Container\ContainerInterface;

/**
 * Class UserHydratorFactory
 * @package Admin\User\Factory
 */
class UserHydratorFactory
{
    public function __invoke(ContainerInterface $container, $requestedName)
    {
        /** @var UserHydrator $hydrator */
        $hydrator = new $requestedName($container->get(RolesHydratingStrategy::class));
        return $hydrator;
    }
}
