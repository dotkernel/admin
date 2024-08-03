<?php

declare(strict_types=1);

namespace AdminTest\Unit\App\Factory;

use Admin\App\Factory\FormsPluginFactory;
use Admin\App\Plugin\FormsPlugin;
use AdminTest\Unit\UnitTest;
use Dot\FlashMessenger\FlashMessengerInterface;
use Laminas\Form\FormElementManager;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class FormsPluginFactoryTest extends UnitTest
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function testWillInvoke(): void
    {
        $container          = $this->createMock(ContainerInterface::class);
        $formElementManager = $this->createMock(FormElementManager::class);
        $flashMessenger     = $this->createMock(FlashMessengerInterface::class);

        $container->method('get')->willReturnMap([
            [FormElementManager::class, $formElementManager],
            [FlashMessengerInterface::class, $flashMessenger],
        ]);

        $formsPlugin = (new FormsPluginFactory())($container);
        $this->assertInstanceOf(FormsPlugin::class, $formsPlugin);
    }
}
