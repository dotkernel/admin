<?php

declare(strict_types=1);

namespace Frontend\App\Factory;

use Dot\FlashMessenger\FlashMessengerInterface;
use Frontend\App\Plugin\FormsPlugin;
use Laminas\Form\FormElementManager;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class FormsPluginFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): FormsPlugin
    {
        return new FormsPlugin(
            $container->get(FormElementManager::class),
            $container->get(FlashMessengerInterface::class)
        );
    }
}
