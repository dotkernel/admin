<?php

declare(strict_types=1);

namespace AdminTest\Unit\Dashboard;

use Admin\Dashboard\RoutesDelegator;
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
                $this->createMock(RouteCollectorInterface::class)
            );

        $application = (new RoutesDelegator())(
            $container,
            '',
            function () {
                return $this->createMock(Application::class);
            }
        );

        $this->assertContainsOnlyInstancesOf(Application::class, [$application]);
    }
}
