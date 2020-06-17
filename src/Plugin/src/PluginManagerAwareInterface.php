<?php

/**
 * @see https://github.com/dotkernel/dot-controller/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-controller/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace Frontend\Plugin;

/**
 * Interface PluginManagerAwareInterface
 * @package Frontend\Plugin
 */
interface PluginManagerAwareInterface
{
    /**
     * @param PluginManager $plugins
     * @return void
     */
    public function setPluginManager(PluginManager $plugins);

    /**
     * @return PluginManager
     */
    public function getPluginManager(): PluginManager;
}
