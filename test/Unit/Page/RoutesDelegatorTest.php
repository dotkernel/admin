<?php

declare(strict_types=1);

namespace AdminTest\Unit\Page;

use Admin\Page\RoutesDelegator;
use AdminTest\Unit\UnitTest;
use Mezzio\Application;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class RoutesDelegatorTest extends UnitTest
{
    /**
     * @throws Exception
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testWillInvoke(): void
    {
        $application = (new RoutesDelegator())(
            $this->createMock(ContainerInterface::class),
            '',
            function () {
                return $this->createMock(Application::class);
            }
        );

        $this->assertInstanceOf(Application::class, $application);
    }
}
