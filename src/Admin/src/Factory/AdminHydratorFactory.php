<?php
/**
 * @see https://github.com/dotkernel/dot-admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-admin/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Admin\Admin\Factory;

use Admin\Admin\Hydrator\AdminHydrator;
use Admin\Admin\Hydrator\RolesHydratingStrategy;
use Psr\Container\ContainerInterface;

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
