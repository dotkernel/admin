<?php

declare(strict_types=1);

namespace FrontendTest\Unit\App\Controller;

use Frontend\App\Controller\DashboardController;
use FrontendTest\Unit\UnitTest;
use Laminas\Authentication\AuthenticationServiceInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception;

class DashboardControllerTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testWillCreate(): void
    {
        $dashboardController = new DashboardController(
            $this->createMock(RouterInterface::class),
            $this->createMock(TemplateRendererInterface::class),
            $this->createMock(AuthenticationServiceInterface::class)
        );
        $this->assertInstanceOf(DashboardController::class, $dashboardController);
    }
}
