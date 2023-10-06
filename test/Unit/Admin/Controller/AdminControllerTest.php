<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\Controller;

use Dot\FlashMessenger\FlashMessengerInterface;
use Frontend\Admin\Controller\AdminController;
use Frontend\Admin\Form\AdminForm;
use Frontend\Admin\Service\AdminServiceInterface;
use Frontend\App\Plugin\FormsPlugin;
use FrontendTest\Unit\UnitTest;
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
        $adminController = new AdminController(
            $this->createMock(AdminServiceInterface::class),
            $this->createMock(RouterInterface::class),
            $this->createMock(TemplateRendererInterface::class),
            $this->createMock(AuthenticationServiceInterface::class),
            $this->createMock(FlashMessengerInterface::class),
            $this->createMock(FormsPlugin::class),
            $this->createMock(AdminForm::class),
        );
        $this->assertInstanceOf(AdminController::class, $adminController);
    }
}
