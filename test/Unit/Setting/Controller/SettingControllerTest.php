<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Setting\Controller;

use Frontend\Admin\Service\AdminService;
use Frontend\Setting\Controller\SettingController;
use Frontend\Setting\Service\SettingService;
use FrontendTest\Unit\UnitTest;
use Laminas\Authentication\AuthenticationServiceInterface;
use Mezzio\Router\RouterInterface;
use PHPUnit\Framework\MockObject\Exception;

class SettingControllerTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testWillCreate(): void
    {
        $adminController = new SettingController(
            $this->createMock(AuthenticationServiceInterface::class),
            $this->createMock(RouterInterface::class),
            $this->createMock(AdminService::class),
            $this->createMock(SettingService::class),
        );
        $this->assertInstanceOf(SettingController::class, $adminController);
    }
}
