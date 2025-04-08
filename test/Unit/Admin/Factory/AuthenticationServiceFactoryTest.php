<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Factory;

use Admin\Admin\Adapter\AuthenticationAdapter;
use Admin\Admin\Factory\AuthenticationServiceFactory;
use AdminTest\Unit\UnitTest;
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

        $this->assertContainsOnlyInstancesOf(AuthenticationService::class, [$service]);
    }
}
