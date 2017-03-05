<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 3/5/2017
 * Time: 12:10 AM
 */

declare(strict_types = 1);

namespace Admin\Admin\Factory;

use Admin\Admin\Hydrator\AdminHydrator;
use Admin\Admin\Hydrator\RolesHydratingStrategy;
use Interop\Container\ContainerInterface;

/**
 * Class AdminHydratorFactory
 * @package Admin\Admin\Factory
 */
class AdminHydratorFactory
{
    public function __invoke(ContainerInterface $container, $requestedName)
    {
        /** @var AdminHydrator $hydrator */
        $hydrator = new $requestedName($container->get(RolesHydratingStrategy::class));
        return $hydrator;
    }
}
