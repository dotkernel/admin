<?php

/**
 * @see https://github.com/dotkernel/dot-controller-plugin-forms/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-controller-plugin-forms/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace Frontend\Plugin\Factory;

use Frontend\Plugin\FormsPlugin;
use Dot\FlashMessenger\FlashMessengerInterface;
use Psr\Container\ContainerInterface;

/**
 * Class FormsPluginFactory
 * @package Dot\Controller\Plugin\Forms\Factory
 */
class FormsPluginFactory
{
    /**
     * @param ContainerInterface $container
     * @return FormsPlugin
     */
    public function __invoke(ContainerInterface $container)
    {
        return new FormsPlugin(
            $container->get('FormElementManager'),
            $container,
            $container->get(FlashMessengerInterface::class)
        );
    }
}
