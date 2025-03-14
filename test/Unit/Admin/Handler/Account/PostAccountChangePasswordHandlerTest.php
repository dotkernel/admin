<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Account;

use Admin\Admin\Form\AccountForm;
use Admin\Admin\Form\ChangePasswordForm;
use Admin\Admin\Handler\Account\PostAccountChangePasswordHandler;
use Admin\App\Message;
use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\Admin;
use Core\Admin\Entity\AdminIdentity;
use Core\Admin\Repository\AdminRepository;
use Core\Admin\Service\AdminServiceInterface;
use Core\App\Exception\IdentityException;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Log\Logger;
use Exception;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception as MockObjectException;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ServerRequestInterface;

class PostAccountChangePasswordHandlerTest extends UnitTest
{
    private MockObject|AdminServiceInterface $adminService;
    private MockObject|RouterInterface $router;
    private MockObject|TemplateRendererInterface $template;
    private MockObject|AuthenticationServiceInterface $authenticationService;
    private MockObject|FlashMessengerInterface $messenger;
    private MockObject|AccountForm $accountForm;
    private MockObject|ChangePasswordForm $changePasswordForm;
    private MockObject|ServerRequestInterface $request;
    private MockObject|AdminIdentity $identity;
    private MockObject|AdminRepository $adminRepository;
    private MockObject|Admin $admin;
    private Logger $logger;

    /**
     * @throws MockObjectException
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->adminService          = $this->createMock(AdminServiceInterface::class);
        $this->router                = $this->createMock(RouterInterface::class);
        $this->template              = $this->createMock(TemplateRendererInterface::class);
        $this->authenticationService = $this->createMock(AuthenticationServiceInterface::class);
        $this->messenger             = $this->createMock(FlashMessengerInterface::class);
        $this->accountForm           = $this->createMock(AccountForm::class);
        $this->changePasswordForm    = $this->createMock(ChangePasswordForm::class);
        $this->request               = $this->createMock(ServerRequestInterface::class);
        $this->identity              = $this->createMock(AdminIdentity::class);
        $this->adminRepository       = $this->createMock(AdminRepository::class);
        $this->admin                 = $this->createMock(Admin::class);
        $this->logger                = new Logger([
            'writers' => [
                'FileWriter' => [
                    'name'     => 'null',
                    'priority' => Logger::ALERT,
                ],
            ],
        ]);
    }

    /**
     * @throws Exception
     */
    public function testInvalidChangePasswordFormDataProvidedWillReturnHtmlResponse(): void
    {
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->authenticationService->method('getIdentity')->willReturn($this->identity);
        $this->adminRepository->method('findOneBy')->willReturn($this->admin);
        $this->adminService->method('getAdminRepository')->willReturn($this->adminRepository);
        $this->changePasswordForm->method('isValid')->willReturn(false);
        $this->accountForm->method('prepare')->willReturn('<form></form>');
        $this->changePasswordForm->method('prepare')->willReturn('<form></form>');

        $handler = new PostAccountChangePasswordHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->authenticationService,
            $this->messenger,
            $this->accountForm,
            $this->changePasswordForm,
            $this->logger,
        );

        $response = $handler->handle($this->request);

        $this->assertSame($response->getHeader('content-type')[0], 'text/html; charset=utf-8');
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }

    public function testInvalidConfirmPasswordProvidedWillReturnRedirectResponse(): void
    {
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->authenticationService->method('getIdentity')->willReturn($this->identity);
        $this->adminRepository->method('findOneBy')->willReturn($this->admin);
        $this->adminService->method('getAdminRepository')->willReturn($this->adminRepository);
        $this->changePasswordForm->method('isValid')->willReturn(true);
        $this->accountForm->method('prepare')->willReturn('<form></form>');
        $this->changePasswordForm->method('prepare')->willReturn('<form></form>');
        $this->changePasswordForm->method('getData')->willReturn(['currentPassword' => 'test']);
        $this->admin->method('verifyPassword')->willReturn(false);

        $this
            ->messenger
            ->expects($this->once())
            ->method('addError')
            ->with(Message::CURRENT_PASSWORD_INCORRECT);

        $handler = new PostAccountChangePasswordHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->authenticationService,
            $this->messenger,
            $this->accountForm,
            $this->changePasswordForm,
            $this->logger,
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_FOUND, $response->getStatusCode());
    }

    public function testThrowIdentityExceptionWillReturnRedirectResponse(): void
    {
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->authenticationService->method('getIdentity')->willReturn($this->identity);
        $this->adminRepository->method('findOneBy')->willReturn($this->admin);
        $this->adminService->method('getAdminRepository')->willReturn($this->adminRepository);
        $this->changePasswordForm->method('isValid')->willReturn(true);
        $this->accountForm->method('prepare')->willReturn('<form></form>');
        $this->changePasswordForm->method('prepare')->willReturn('<form></form>');
        $this->changePasswordForm->method('getData')->willReturn(['currentPassword' => 'test']);
        $this->admin->method('verifyPassword')->willReturn(true);
        $this->adminService->method('updateAdmin')->willThrowException(new IdentityException());

        $this
            ->messenger
            ->expects($this->once())
            ->method('addError')
            ->with((new IdentityException())->getMessage());

        $this
            ->adminService
            ->expects($this->once())
            ->method('updateAdmin');

        $handler = new PostAccountChangePasswordHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->authenticationService,
            $this->messenger,
            $this->accountForm,
            $this->changePasswordForm,
            $this->logger,
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_FOUND, $response->getStatusCode());
    }

    public function testThrowExceptionWillReturnRedirectResponse(): void
    {
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->authenticationService->method('getIdentity')->willReturn($this->identity);
        $this->adminRepository->method('findOneBy')->willReturn($this->admin);
        $this->adminService->method('getAdminRepository')->willReturn($this->adminRepository);
        $this->changePasswordForm->method('isValid')->willReturn(true);
        $this->accountForm->method('prepare')->willReturn('<form></form>');
        $this->changePasswordForm->method('prepare')->willReturn('<form></form>');
        $this->changePasswordForm->method('getData')->willReturn(['currentPassword' => 'test']);
        $this->admin->method('verifyPassword')->willReturn(true);
        $this->adminService->method('updateAdmin')->willThrowException(new Exception());

        $this
            ->messenger
            ->expects($this->once())
            ->method('addError')
            ->with(Message::AN_ERROR_OCCURRED);

        $handler = new PostAccountChangePasswordHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->authenticationService,
            $this->messenger,
            $this->accountForm,
            $this->changePasswordForm,
            $this->logger,
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_FOUND, $response->getStatusCode());
    }

    public function testValidFormDataWillReturnRedirectResponse(): void
    {
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->authenticationService->method('getIdentity')->willReturn($this->identity);
        $this->adminRepository->method('findOneBy')->willReturn($this->admin);
        $this->adminService->method('getAdminRepository')->willReturn($this->adminRepository);
        $this->changePasswordForm->method('isValid')->willReturn(true);
        $this->accountForm->method('prepare')->willReturn('<form></form>');
        $this->changePasswordForm->method('prepare')->willReturn('<form></form>');
        $this->changePasswordForm->method('getData')->willReturn(['currentPassword' => 'test']);
        $this->admin->method('verifyPassword')->willReturn(true);

        $this
            ->messenger
            ->expects($this->once())
            ->method('addSuccess')
            ->with(Message::ACCOUNT_UPDATE_SUCCESSFULLY);

        $handler = new PostAccountChangePasswordHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->authenticationService,
            $this->messenger,
            $this->accountForm,
            $this->changePasswordForm,
            $this->logger,
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_FOUND, $response->getStatusCode());
    }
}
