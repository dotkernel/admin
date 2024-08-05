<?php

declare(strict_types=1);

namespace Admin\App\Factory;

use Admin\App\Resolver\EntityListenerResolver;
use Psr\Container\ContainerInterface;

class EntityListenerResolverFactory
{
    public function __invoke(ContainerInterface $container): EntityListenerResolver
    {
        return new EntityListenerResolver($container);
    }
}
