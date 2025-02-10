<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Controller;

use Admin\Admin\Controller\AdminController;
use Admin\Admin\Form\AdminForm;
use Admin\Admin\Service\AdminRoleServiceInterface;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Plugin\FormsPlugin;
use Admin\Setting\Service\SettingService;
use AdminTest\Unit\UnitTest;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Log\Logger;
use Laminas\Authentication\AuthenticationServiceInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception;

class AdminControllerTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testWillCreate(): void
    {
        $logger          = new Logger([
            'writers' => [
                'FileWriter' => [
                    'name'     => 'null',
                    'priority' => Logger::ALERT,
                ],
            ],
        ]);
        $adminController = new AdminController(
            $this->createMock(AdminServiceInterface::class),
            $this->createMock(AdminRoleServiceInterface::class),
            $this->createMock(RouterInterface::class),
            $this->createMock(TemplateRendererInterface::class),
            $this->createMock(AuthenticationServiceInterface::class),
            $this->createMock(FlashMessengerInterface::class),
            $this->createMock(FormsPlugin::class),
            $this->createMock(AdminForm::class),
            $this->createMock(SettingService::class),
            $logger,
        );
        $this->assertInstanceOf(AdminController::class, $adminController);
    }
}
