<?php

/**
 * @see https://github.com/dotkernel/frontend/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/frontend/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace Frontend\User\Doctrine;

use Doctrine\ORM\Mapping\DefaultEntityListenerResolver;
use Psr\Container\ContainerInterface;

/**
 * Class EntityListenerResolver
 * @package Frontend\User\Doctrine\Service
 */
class EntityListenerResolver extends DefaultEntityListenerResolver
{
    /** @var  ContainerInterface */
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
     * @param string $className
     * @return mixed
     */
    public function resolve($className)
    {
        return $this->container->get($className);
    }
}
