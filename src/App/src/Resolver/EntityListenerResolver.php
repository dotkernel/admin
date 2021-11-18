<?php

declare(strict_types=1);

namespace Frontend\App\Resolver;

use Doctrine\ORM\Mapping\DefaultEntityListenerResolver;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class EntityListenerResolver
 * @package Frontend\App\Doctrine\Resolver
 */
class EntityListenerResolver extends DefaultEntityListenerResolver
{
    protected ContainerInterface $container;

    /**
     * EntityListenerResolver constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $className
     * @return mixed|object
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function resolve($className)
    {
        return $this->container->get($className);
    }
}
