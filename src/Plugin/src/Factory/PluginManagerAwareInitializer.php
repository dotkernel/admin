<?php

/**
 * @see https://github.com/dotkernel/dot-controller/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-controller/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace Frontend\Plugin\Factory;

use Frontend\Plugin\PluginManager;
use Frontend\Plugin\PluginManagerAwareInterface;
use Psr\Container\ContainerInterface;

/**
 * Class PluginManagerAwareInitializer
 * @package Frontend\Plugin\Factory
 */
class PluginManagerAwareInitializer
{
    /**
     * @param ContainerInterface $container
     * @param object $instance
     */
    public function __invoke(ContainerInterface $container, $instance)
    {
        if ($instance instanceof PluginManagerAwareInterface) {
            $pluginManager = $container->get(PluginManager::class);
            $instance->setPluginManager($pluginManager);
        }
    }
}
