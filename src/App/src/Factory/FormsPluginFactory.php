<?php

/**
 * @see https://github.com/dotkernel/dot-controller-plugin-forms/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-controller-plugin-forms/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace Frontend\App\Factory;

use Dot\FlashMessenger\FlashMessengerInterface;
use Frontend\App\Plugin\FormsPlugin;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class FormsPluginFactory
 * @package Frontend\App\Factory
 */
class FormsPluginFactory
{
    /**
     * @param ContainerInterface $container
     * @return FormsPlugin
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): FormsPlugin
    {
        return new FormsPlugin(
            $container->get('FormElementManager'),
            $container,
            $container->get(FlashMessengerInterface::class)
        );
    }
}
