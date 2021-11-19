<?php

/**
 * @see https://github.com/dotkernel/frontend/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/frontend/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace Frontend\User\Doctrine;

use Psr\Container\ContainerInterface;

/**
 * Class EntityListenerResolverFactory
 * @package Frontend\Admin\Doctrine\Factory
 */
class EntityListenerResolverFactory
{
    /**
     * @param ContainerInterface $container
     * @return EntityListenerResolver
     */
    public function __invoke(ContainerInterface $container): EntityListenerResolver
    {
        return new EntityListenerResolver($container);
    }
}
