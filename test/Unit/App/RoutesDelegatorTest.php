<?php

declare(strict_types=1);

namespace FrontendTest\Unit\App;

use Frontend\Admin\RoutesDelegator;
use FrontendTest\Unit\UnitTest;
use Mezzio\Application;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Container\ContainerInterface;

class RoutesDelegatorTest extends UnitTest
{
    /**
     * @throws Exception
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
