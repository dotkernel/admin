<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Account;

use Admin\Admin\Form\AccountForm;
use Admin\Admin\Form\ChangePasswordForm;
use Admin\Admin\Handler\Account\GetEditAccountFormHandler;
use Admin\Admin\Service\AdminServiceInterface;
use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\Admin;
use Core\Admin\Entity\AdminIdentity;
use Core\Admin\Repository\AdminRepository;
use Dot\FlashMessenger\FlashMessengerInterface;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Http\Message\ServerRequestInterface;

class GetAccountEditFormHandlerTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testWillReturnHtmlTemplate(): void
    {
        $adminService          = $this->createMock(AdminServiceInterface::class);
        $router                = $this->createMock(RouterInterface::class);
        $template              = $this->createMock(TemplateRendererInterface::class);
        $authenticationService = $this->createMock(AuthenticationServiceInterface::class);
        $accountForm           = $this->createMock(AccountForm::class);
        $changePasswordForm    = $this->createMock(ChangePasswordForm::class);
        $messenger             = $this->createMock(FlashMessengerInterface::class);
        $request               = $this->createMock(ServerRequestInterface::class);
        $identity              = $this->createMock(AdminIdentity::class);
        $adminRepository       = $this->createMock(AdminRepository::class);
        $admin                 = $this->createMock(Admin::class);

        $identity->method('getUuid')->willReturn('test');
        $authenticationService->method('getIdentity')->willReturn($identity);
        $adminRepository->method('findOneBy')->willReturn($admin);

        $adminService->method('getAdminRepository')->willReturn($adminRepository);

        $handler = new GetEditAccountFormHandler(
            $adminService,
            $router,
            $template,
            $authenticationService,
            $accountForm,
            $changePasswordForm,
            $messenger,
        );

        $response = $handler->handle($request);

        $this->assertSame($response->getHeader('content-type')[0], 'text/html; charset=utf-8');
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
