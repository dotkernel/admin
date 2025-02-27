<?php

namespace AdminTest\Unit\Admin\Handler\Account;

use Admin\Admin\Entity\Admin;
use Admin\Admin\Entity\AdminIdentity;
use Admin\Admin\Form\AccountForm;
use Admin\Admin\Form\ChangePasswordForm;
use Admin\Admin\Handler\Account\PostAccountEditHandler;
use Admin\Admin\Repository\AdminRepository;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Exception\IdentityException;
use Admin\App\Message;
use AdminTest\Unit\UnitTest;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Log\Logger;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception as MockObjectException;
use Psr\Http\Message\ServerRequestInterface;
use Exception;

class PostAccountEditHandlerTest extends UnitTest
{
    private AdminServiceInterface $adminService;
    private RouterInterface $router;
    private TemplateRendererInterface $template;
    private AuthenticationServiceInterface $authenticationService;
    private AccountForm $accountForm;
    private ChangePasswordForm $changePasswordForm;
    private FlashMessengerInterface $messenger;
    private Logger $logger;
    private AdminIdentity $identity;
    private AdminRepository $adminRepository;
    private ServerRequestInterface $request;

    private Admin $admin;

    /**
     * @throws MockObjectException
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->adminService = $this->createMock(AdminServiceInterface::class);
        $this->router = $this->createMock(RouterInterface::class);
        $this->template = $this->createMock(TemplateRendererInterface::class);
        $this->authenticationService = $this->createMock(AuthenticationServiceInterface::class);
        $this->accountForm = $this->createMock(AccountForm::class);
        $this->changePasswordForm = $this->createMock(ChangePasswordForm::class);
        $this->messenger = $this->createMock(FlashMessengerInterface::class);
        $this->identity = $this->createMock(AdminIdentity::class);
        $this->adminRepository = $this->createMock(AdminRepository::class);
        $this->request = $this->createMock(ServerRequestInterface::class);
        $this->admin = $this->createMock(Admin::class);
        $this->logger          = new Logger([
            'writers' => [
                'FileWriter' => [
                    'name'     => 'null',
                    'priority' => Logger::ALERT,
                ],
            ],
        ]);
    }

    public function testInvalidAccountFormDataProvidedWillReturnHtmlResponse(): void
    {
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->authenticationService->method('getIdentity')->willReturn($this->identity);
        $this->adminService->method('getAdminRepository')->willReturn($this->adminRepository);
        $this->accountForm->method('isValid')->willReturn(false);

        $handler = new PostAccountEditHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->authenticationService,
            $this->accountForm,
            $this->changePasswordForm,
            $this->messenger,
            $this->logger,
        );

        $response = $handler->handle($this->request);

        $this->assertSame($response->getHeader('content-type')[0], 'text/html; charset=utf-8');
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }

    public function testThrowIdentityExceptionWillReturnRedirectResponse(): void
    {
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->authenticationService->method('getIdentity')->willReturn($this->identity);
        $this->adminService->method('getAdminRepository')->willReturn($this->adminRepository);
        $this->accountForm->method('isValid')->willReturn(true);
        $this->accountForm->method('prepare')->willReturn('<form></form>');
        $this->changePasswordForm->method('prepare')->willReturn('<form></form>');
        $this->accountForm->method('getData')->willReturn(['test' => 'test']);
        $this->adminService->method('updateAdmin')->willThrowException(new IdentityException);

        $this
            ->messenger
            ->expects($this->exactly(1))
            ->method('addError')
            ->with(Message::AN_ERROR_OCCURRED);

        $this->adminService->method('updateAdmin')->willThrowException(new IdentityException);

        $handler = new PostAccountEditHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->authenticationService,
            $this->accountForm,
            $this->changePasswordForm,
            $this->messenger,
            $this->logger,
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_FOUND, $response->getStatusCode());
    }

    public function testThrowExceptionWillReturnRedirectResponse(): void
    {
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->authenticationService->method('getIdentity')->willReturn($this->identity);
        $this->adminService->method('getAdminRepository')->willReturn($this->adminRepository);
        $this->accountForm->method('isValid')->willReturn(true);
        $this->accountForm->method('prepare')->willReturn('<form></form>');
        $this->changePasswordForm->method('prepare')->willReturn('<form></form>');
        $this->accountForm->method('getData')->willReturn(['test' => 'test']);
        $this->adminService->method('updateAdmin')->willThrowException(new Exception);

        $this
            ->messenger
            ->expects($this->exactly(1))
            ->method('addError')
            ->with(Message::AN_ERROR_OCCURRED);

        $handler = new PostAccountEditHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->authenticationService,
            $this->accountForm,
            $this->changePasswordForm,
            $this->messenger,
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
        $this->accountForm->method('isValid')->willReturn(true);
        $this->accountForm->method('prepare')->willReturn('<form></form>');
        $this->changePasswordForm->method('prepare')->willReturn('<form></form>');
        $this->accountForm->method('getData')->willReturn(['currentPassword' => 'test']);
        $this->admin->method('verifyPassword')->willReturn(true);

        $this
            ->messenger
            ->expects($this->exactly(1))
            ->method('addSuccess')
            ->with(Message::ACCOUNT_UPDATE_SUCCESSFULLY);

        $handler = new PostAccountEditHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->authenticationService,
            $this->accountForm,
            $this->changePasswordForm,
            $this->messenger,
            $this->logger,
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_FOUND, $response->getStatusCode());
    }
}