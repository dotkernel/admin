<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin;

use Admin\Admin\RoutesDelegator;
use AdminTest\Unit\UnitTest;
use Dot\Router\RouteCollectorInterface;
use Mezzio\Application;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class RoutesDelegatorTest extends UnitTest
{
    /**
     * @throws ContainerExceptionInterface
     * @throws Exception
     * @throws NotFoundExceptionInterface
     */
    public function testWillInvoke(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $container
            ->expects($this->once())
            ->method('get')
            ->with(RouteCollectorInterface::class)
            ->willReturn(
                $this->createStub(RouteCollectorInterface::class)
            );

        $application = (new RoutesDelegator())(
            $container,
            '',
            function () {
                return $this->createStub(Application::class);
            }
        );

        $this->assertContainsOnlyInstancesOf(Application::class, [$application]);
    }
}
