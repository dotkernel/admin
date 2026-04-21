<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Account;

use Admin\Admin\Form\AccountForm;
use Admin\Admin\Form\ChangePasswordForm;
use Admin\Admin\Handler\Account\PostEditAccountHandler;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Exception\ConflictException;
use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\Admin;
use Core\Admin\Entity\AdminIdentity;
use Core\App\Message;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Log\Logger;
use Exception;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception as MockObjectException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use Psr\Http\Message\ServerRequestInterface;

class PostAccountEditHandlerTest extends UnitTest
{
    private Stub&AdminServiceInterface $adminService;
    private Stub&RouterInterface $router;
    private Stub&TemplateRendererInterface $template;
    private Stub&AuthenticationServiceInterface $authenticationService;
    private Stub&AccountForm $accountForm;
    private Stub&ChangePasswordForm $changePasswordForm;
    private MockObject&FlashMessengerInterface $messenger;
    private Logger $logger;
    private Stub&AdminIdentity $identity;
    private Stub&ServerRequestInterface $request;

    private Stub&Admin $admin;

    /**
     * @throws MockObjectException
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->adminService          = $this->createStub(AdminServiceInterface::class);
        $this->router                = $this->createStub(RouterInterface::class);
        $this->template              = $this->createStub(TemplateRendererInterface::class);
        $this->authenticationService = $this->createStub(AuthenticationServiceInterface::class);
        $this->accountForm           = $this->createStub(AccountForm::class);
        $this->changePasswordForm    = $this->createStub(ChangePasswordForm::class);
        $this->messenger             = $this->createMock(FlashMessengerInterface::class);
        $this->identity              = $this->createStub(AdminIdentity::class);
        $this->request               = $this->createStub(ServerRequestInterface::class);
        $this->admin                 = $this->createStub(Admin::class);
        $this->logger                = new Logger([
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
        $this->accountForm->method('isValid')->willReturn(false);
        $this->messenger->expects($this->never())->method('addError');

        $handler = new PostEditAccountHandler(
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

    public function testThrowConflictExceptionWillReturnRedirectResponse(): void
    {
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->authenticationService->method('getIdentity')->willReturn($this->identity);
        $this->accountForm->method('isValid')->willReturn(true);
        $this->accountForm->method('prepare')->willReturn('<form></form>');
        $this->changePasswordForm->method('prepare')->willReturn('<form></form>');
        $this->accountForm->method('getData')->willReturn(['test' => 'test']);
        $this->adminService->method('saveAdmin')->willThrowException(
            new ConflictException(Message::DUPLICATE_IDENTITY)
        );

        $this
            ->messenger
            ->expects($this->once())
            ->method('addError')
            ->with(Message::DUPLICATE_IDENTITY);

        $handler = new PostEditAccountHandler(
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
        $this->accountForm->method('isValid')->willReturn(true);
        $this->accountForm->method('prepare')->willReturn('<form></form>');
        $this->changePasswordForm->method('prepare')->willReturn('<form></form>');
        $this->accountForm->method('getData')->willReturn(['test' => 'test']);
        $this->adminService->method('saveAdmin')->willThrowException(new Exception());

        $this
            ->messenger
            ->expects($this->once())
            ->method('addError')
            ->with(Message::AN_ERROR_OCCURRED);

        $handler = new PostEditAccountHandler(
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
        $this->accountForm->method('isValid')->willReturn(true);
        $this->accountForm->method('prepare')->willReturn('<form></form>');
        $this->changePasswordForm->method('prepare')->willReturn('<form></form>');
        $this->accountForm->method('getData')->willReturn(['currentPassword' => 'test']);
        $this->admin->method('verifyPassword')->willReturn(true);

        $this
            ->messenger
            ->expects($this->once())
            ->method('addSuccess')
            ->with(Message::ACCOUNT_UPDATED);

        $handler = new PostEditAccountHandler(
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
