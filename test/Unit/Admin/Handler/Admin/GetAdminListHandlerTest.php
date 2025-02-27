<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Admin;

use Admin\Admin\Entity\Admin;
use Admin\Admin\Entity\AdminIdentity;
use Admin\Admin\Form\AdminForm;
use Admin\Admin\Handler\Admin\GetAdminListHandler;
use Admin\Admin\Repository\AdminRepository;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\Setting\Service\SettingService;
use AdminTest\Unit\UnitTest;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Http\Message\ServerRequestInterface;

class GetAdminListHandlerTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testListAdminWillReturnHtmlResponse(): void
    {
        $adminService          = $this->createMock(AdminServiceInterface::class);
        $router                = $this->createMock(RouterInterface::class);
        $template              = $this->createMock(TemplateRendererInterface::class);
        $authenticationService = $this->createMock(AuthenticationServiceInterface::class);
        $form                  = $this->createMock(AdminForm::class);
        $settingService        = $this->createMock(SettingService::class);
        $adminRepository       = $this->createMock(AdminRepository::class);

        $settingService->method('findOneBy')->willReturn(null);
        $adminRepository->method('findOneBy')->willReturn($this->createMock(Admin::class));
        $adminService->method('getAdmins')->willReturn([
            'rows'   => [],
            'total'  => 1,
            'offset' => 1,
            'limit'  => 1,
        ]);

        $adminService->method('getAdminRepository')->willReturn($adminRepository);
        $authenticationService
            ->method('getIdentity')
            ->willReturn(
                $this->createMock(AdminIdentity::class)
            );

        $handler = new GetAdminListHandler(
            $adminService,
            $router,
            $template,
            $authenticationService,
            $form,
            $settingService,
        );

        $response = $handler->handle($this->createMock(ServerRequestInterface::class));

        $this->assertSame($response->getHeader('content-type')[0], 'text/html; charset=utf-8');
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
