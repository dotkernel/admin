<?php
/**
 * @see https://github.com/dotkernel/admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/admin/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Admin\User\Factory;

use Admin\User\Hydrator\UserHydrator;
use Admin\User\Hydrator\RolesHydratingStrategy;
use Psr\Container\ContainerInterface;

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
