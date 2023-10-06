<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\Factory;

use Frontend\Admin\Adapter\AuthenticationAdapter;
use Frontend\Admin\Factory\AuthenticationServiceFactory;
use FrontendTest\Unit\UnitTest;
use Laminas\Authentication\AuthenticationService;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class AuthenticationServiceFactoryTest extends UnitTest
{
    /**
     * @throws Exception
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testWillInvoke(): void
    {
        $authenticationAdapter = $this->createMock(AuthenticationAdapter::class);

        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->once())
            ->method('get')
            ->with(AuthenticationAdapter::class)
            ->willReturn($authenticationAdapter);

        $service = (new AuthenticationServiceFactory())($container);
        $this->assertInstanceOf(AuthenticationService::class, $service);
    }
}
