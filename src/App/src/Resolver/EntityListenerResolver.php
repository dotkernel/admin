<?php

declare(strict_types=1);

namespace Frontend\App\Resolver;

use Doctrine\ORM\Mapping\DefaultEntityListenerResolver;
use Psr\Container\ContainerInterface;

/**
 * Class EntityListenerResolver
 * @package Frontend\App\Doctrine\Resolver
 */
class EntityListenerResolver extends DefaultEntityListenerResolver
{
    /** @var ContainerInterface $container */
    protected $container;

    /**
     * EntityListenerResolver constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param $className
     * @return mixed
     */
    public function resolve($className)
    {
        return $this->container->get($className);
    }
}
