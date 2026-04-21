<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Account;

use Admin\Admin\Form\AccountForm;
use Admin\Admin\Form\ChangePasswordForm;
use Admin\Admin\Handler\Account\PostChangeAccountPasswordHandler;
use Admin\Admin\Service\AdminServiceInterface;
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

class PostAccountChangePasswordHandlerTest extends UnitTest
{
    private Stub&AdminServiceInterface $adminService;
    private Stub&RouterInterface $router;
    private Stub&TemplateRendererInterface $template;
    private Stub&AuthenticationServiceInterface $authenticationService;
    private MockObject&FlashMessengerInterface $messenger;
    private Stub&AccountForm $accountForm;
    private Stub&ChangePasswordForm $changePasswordForm;
    private Stub&ServerRequestInterface $request;
    private Stub&AdminIdentity $identity;
    private Stub&Admin $admin;
    private Logger $logger;

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
        $this->messenger             = $this->createMock(FlashMessengerInterface::class);
        $this->accountForm           = $this->createStub(AccountForm::class);
        $this->changePasswordForm    = $this->createStub(ChangePasswordForm::class);
        $this->request               = $this->createStub(ServerRequestInterface::class);
        $this->identity              = $this->createStub(AdminIdentity::class);
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

    /**
     * @throws Exception
     */
    public function testInvalidChangePasswordFormDataProvidedWillReturnHtmlResponse(): void
    {
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->authenticationService->method('getIdentity')->willReturn($this->identity);
        $this->adminService->method('findAdmin')->willReturn($this->admin);
        $this->changePasswordForm->method('isValid')->willReturn(false);
        $this->accountForm->method('prepare')->willReturn('<form></form>');
        $this->changePasswordForm->method('prepare')->willReturn('<form></form>');
        $this->messenger->expects($this->never())->method('addError');

        $handler = new PostChangeAccountPasswordHandler(
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
        $this->adminService->method('findAdmin')->willReturn($this->admin);
        $this->changePasswordForm->method('isValid')->willReturn(true);
        $this->accountForm->method('prepare')->willReturn('<form></form>');
        $this->changePasswordForm->method('prepare')->willReturn('<form></form>');
        $this->changePasswordForm->method('getData')->willReturn(['currentPassword' => 'test']);
        $this->admin->method('verifyPassword')->willReturn(false);

        $this
            ->messenger
            ->expects($this->once())
            ->method('addError')
            ->with(Message::INVALID_CURRENT_PASSWORD);

        $handler = new PostChangeAccountPasswordHandler(
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
        $this->adminService->method('findAdmin')->willReturn($this->admin);
        $this->changePasswordForm->method('isValid')->willReturn(true);
        $this->accountForm->method('prepare')->willReturn('<form></form>');
        $this->changePasswordForm->method('prepare')->willReturn('<form></form>');
        $this->changePasswordForm->method('getData')->willReturn(['currentPassword' => 'test']);
        $this->admin->method('verifyPassword')->willReturn(true);
        $this->adminService->method('saveAdmin')->willThrowException(new Exception());

        $this
            ->messenger
            ->expects($this->once())
            ->method('addError')
            ->with(Message::AN_ERROR_OCCURRED);

        $handler = new PostChangeAccountPasswordHandler(
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
        $this->adminService->method('findAdmin')->willReturn($this->admin);
        $this->changePasswordForm->method('isValid')->willReturn(true);
        $this->accountForm->method('prepare')->willReturn('<form></form>');
        $this->changePasswordForm->method('prepare')->willReturn('<form></form>');
        $this->changePasswordForm->method('getData')->willReturn(['currentPassword' => 'test']);
        $this->admin->method('verifyPassword')->willReturn(true);

        $this
            ->messenger
            ->expects($this->once())
            ->method('addSuccess')
            ->with(Message::ACCOUNT_UPDATED);

        $handler = new PostChangeAccountPasswordHandler(
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
