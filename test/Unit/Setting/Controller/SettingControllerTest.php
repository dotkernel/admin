<?php

declare(strict_types=1);

namespace AdminTest\Unit\Setting\Controller;

use Admin\Admin\Service\AdminService;
use Admin\Setting\Controller\SettingController;
use Admin\Setting\Service\SettingService;
use AdminTest\Unit\UnitTest;
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
