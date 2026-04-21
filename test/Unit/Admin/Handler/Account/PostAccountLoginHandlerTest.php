<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Account;

use Admin\Admin\Adapter\AuthenticationAdapter;
use Admin\Admin\Form\LoginForm;
use Admin\Admin\Handler\Account\PostLoginAccountHandler;
use Admin\Admin\Service\AdminLoginServiceInterface;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Plugin\FormsPlugin;
use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\AdminIdentity;
use Core\Admin\Enum\AdminStatusEnum;
use Core\App\Message;
use Core\App\Service\AuthenticationServiceInterface;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Log\Logger;
use Exception;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface as LaminasAuthenticationServiceInterface;
use Laminas\Authentication\Result;
use Laminas\Authentication\Storage\StorageInterface;
use Mezzio\Router\RouterInterface;
use PHPUnit\Framework\MockObject\Exception as MockObjectException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

class PostAccountLoginHandlerTest extends UnitTest
{
    private Stub&AdminServiceInterface $adminService;
    private MockObject&AdminLoginServiceInterface $adminLoginService;
    private Stub&RouterInterface $router;
    private MockObject&LaminasAuthenticationServiceInterface&AuthenticationServiceInterface $authenticationService;
    private MockObject&FlashMessengerInterface $messenger;
    private Stub&FormsPlugin $formsPlugin;
    private Stub&LoginForm $loginForm;
    private Logger $logger;
    private Stub&ServerRequestInterface $request;
    private Stub&Result $authenticationResult;
    private Stub&AuthenticationAdapter $authenticationAdapter;
    private Stub&AdminIdentity $identity;
    private MockObject&StorageInterface $storage;

    /**
     * @throws MockObjectException
     */
    public function setUp(): void
    {
        parent::setUp();

        /** @var MockObject&LaminasAuthenticationServiceInterface&AuthenticationServiceInterface $authenticationService */
        $authenticationService = $this->createMockForIntersectionOfInterfaces([
            LaminasAuthenticationServiceInterface::class,
            AuthenticationServiceInterface::class,
        ]);

        $this->authenticationService = $authenticationService;
        $this->adminService          = $this->createStub(AdminServiceInterface::class);
        $this->adminLoginService     = $this->createMock(AdminLoginServiceInterface::class);
        $this->router                = $this->createStub(RouterInterface::class);
        $this->messenger             = $this->createMock(FlashMessengerInterface::class);
        $this->formsPlugin           = $this->createStub(FormsPlugin::class);
        $this->loginForm             = $this->createStub(LoginForm::class);
        $this->request               = $this->createStub(ServerRequestInterface::class);
        $this->authenticationResult  = $this->createStub(Result::class);
        $this->authenticationAdapter = $this->createStub(AuthenticationAdapter::class);
        $this->identity              = $this->createStub(AdminIdentity::class);
        $this->storage               = $this->createMock(StorageInterface::class);
        $this->logger                = new Logger([
            'writers' => [
                'FileWriter' => [
                    'name'     => 'null',
                    'priority' => Logger::ALERT,
                ],
            ],
        ]);
    }

    public function testAdminAlreadyLoggedWillReturnRedirectResponse(): void
    {
        $this->authenticationService->expects($this->once())->method('hasIdentity')->willReturn(true);

        $this->messenger->expects($this->never())->method('addError');
        $this->adminLoginService->expects($this->never())->method('logFailedLogin');
        $this->adminLoginService->expects($this->never())->method('logSuccessfulLogin');
        $this->storage->expects($this->never())->method('write');

        $handler = new PostLoginAccountHandler(
            $this->adminService,
            $this->adminLoginService,
            $this->router,
            $this->authenticationService,
            $this->messenger,
            $this->formsPlugin,
            $this->loginForm,
            $this->logger,
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_FOUND, $response->getStatusCode());
    }

    /**
     * @throws MockObjectException
     */
    public function testInvalidLoginFormDataProvidedWillReturnRedirectResponse(): void
    {
        $this->authenticationService->expects($this->once())->method('hasIdentity')->willReturn(false);
        $this->request->method('getUri')->willReturn($this->createStub(UriInterface::class));
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->loginForm->method('isValid')->willReturn(false);
        $this->request->method('getQueryParams')->willReturn([]);
        $this->request->method('getServerParams')->willReturn([]);

        $this->messenger->expects($this->atLeastOnce())->method('addError');
        $this->adminLoginService->expects($this->never())->method('logFailedLogin');
        $this->adminLoginService->expects($this->never())->method('logSuccessfulLogin');
        $this->storage->expects($this->never())->method('write');

        $handler = new PostLoginAccountHandler(
            $this->adminService,
            $this->adminLoginService,
            $this->router,
            $this->authenticationService,
            $this->messenger,
            $this->formsPlugin,
            $this->loginForm,
            $this->logger,
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_SEE_OTHER, $response->getStatusCode());
    }

    /**
     * @throws MockObjectException
     */
    public function testInvalidPasswordProvidedWillReturnRedirectResponse(): void
    {
        $this->authenticationResult->method('isValid')->willReturn(false);
        $this->authenticationResult->method('getMessages')->willReturn([]);
        $this->authenticationService->expects($this->once())->method('hasIdentity')->willReturn(false);
        $this->authenticationService->expects($this->once())->method('authenticate')
            ->willReturn($this->authenticationResult);
        $this->authenticationService->expects($this->once())->method('getAdapter')
            ->willReturn($this->authenticationAdapter);
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->request->method('getServerParams')->willReturn([]);
        $this->request->method('getUri')->willReturn($this->createStub(UriInterface::class));
        $this->loginForm->method('isValid')->willReturn(true);
        $this->loginForm->method('getData')->willReturn(['identity' => 'test', 'password' => 'test']);
        $this->authenticationAdapter->method('setIdentity')->willReturn($this->authenticationAdapter);
        $this->authenticationAdapter->method('setCredential')->willReturn($this->authenticationAdapter);

        $this->messenger->expects($this->atLeastOnce())->method('addError');
        $this->adminLoginService->expects($this->atLeastOnce())->method('logFailedLogin');
        $this->storage->expects($this->never())->method('write');

        $handler = new PostLoginAccountHandler(
            $this->adminService,
            $this->adminLoginService,
            $this->router,
            $this->authenticationService,
            $this->messenger,
            $this->formsPlugin,
            $this->loginForm,
            $this->logger,
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_SEE_OTHER, $response->getStatusCode());
    }

    /**
     * @throws MockObjectException
     */
    public function testAdminInactiveWillReturnRedirectResponse(): void
    {
        $this->identity->method('getStatus')->willReturn(AdminStatusEnum::Inactive);
        $this->authenticationResult->method('isValid')->willReturn(true);
        $this->authenticationResult->method('getMessages')->willReturn([]);
        $this->authenticationResult->method('getIdentity')->willReturn($this->identity);
        $this->authenticationService->expects($this->once())->method('hasIdentity')->willReturn(false);
        $this->authenticationService->expects($this->once())->method('authenticate')
            ->willReturn($this->authenticationResult);
        $this->authenticationService->expects($this->once())->method('getAdapter')
            ->willReturn($this->authenticationAdapter);
        $this->authenticationService->expects($this->atLeastOnce())->method('clearIdentity');
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->request->method('getServerParams')->willReturn([]);
        $this->request->method('getUri')->willReturn($this->createStub(UriInterface::class));
        $this->loginForm->method('isValid')->willReturn(true);
        $this->loginForm->method('getData')->willReturn(['identity' => 'test', 'password' => 'test']);
        $this->authenticationAdapter->method('setIdentity')->willReturn($this->authenticationAdapter);
        $this->authenticationAdapter->method('setCredential')->willReturn($this->authenticationAdapter);

        $this->messenger->expects($this->atLeastOnce())->method('addError')
            ->with(Message::ADMIN_INACTIVE);
        $this->adminLoginService->expects($this->never())->method('logFailedLogin');
        $this->adminLoginService->expects($this->never())->method('logSuccessfulLogin');
        $this->storage->expects($this->never())->method('write');

        $handler = new PostLoginAccountHandler(
            $this->adminService,
            $this->adminLoginService,
            $this->router,
            $this->authenticationService,
            $this->messenger,
            $this->formsPlugin,
            $this->loginForm,
            $this->logger,
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_SEE_OTHER, $response->getStatusCode());
    }

    /**
     * @throws MockObjectException
     */
    public function testAdminLoginThrowsExceptionWillReturnRedirectResponse(): void
    {
        $this->authenticationService->expects($this->once())->method('hasIdentity')->willReturn(false);
        $this->request->method('getUri')->willReturn($this->createStub(UriInterface::class));
        $this->throwException(new Exception());

        $this->messenger->expects($this->atLeastOnce())->method('addError')
            ->with(Message::AN_ERROR_OCCURRED);
        $this->adminLoginService->expects($this->never())->method('logSuccessfulLogin');
        $this->adminLoginService->expects($this->never())->method('logFailedLogin');
        $this->storage->expects($this->never())->method('write');

        $handler = new PostLoginAccountHandler(
            $this->adminService,
            $this->adminLoginService,
            $this->router,
            $this->authenticationService,
            $this->messenger,
            $this->formsPlugin,
            $this->loginForm,
            $this->logger,
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }

    /**
     * @throws MockObjectException
     */
    public function testAdminLoginSuccessfulWillReturnRedirectResponse(): void
    {
        $this->identity->method('isActive')->willReturn(true);
        $this->authenticationResult->method('isValid')->willReturn(true);
        $this->authenticationResult->method('getMessages')->willReturn([]);
        $this->authenticationResult->method('getIdentity')->willReturn($this->identity);
        $this->authenticationService->expects($this->once())->method('hasIdentity')->willReturn(false);
        $this->authenticationService->expects($this->once())->method('authenticate')
            ->willReturn($this->authenticationResult);
        $this->authenticationService->expects($this->once())->method('getStorage')->willReturn($this->storage);
        $this->authenticationService->expects($this->once())->method('getAdapter')
            ->willReturn($this->authenticationAdapter);
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->request->method('getServerParams')->willReturn([]);
        $this->request->method('getUri')->willReturn($this->createStub(UriInterface::class));
        $this->loginForm->method('isValid')->willReturn(true);
        $this->loginForm->method('getData')->willReturn(['identity' => 'test', 'password' => 'test']);
        $this->authenticationAdapter->method('setIdentity')->willReturn($this->authenticationAdapter);
        $this->authenticationAdapter->method('setCredential')->willReturn($this->authenticationAdapter);

        $this->adminLoginService->expects($this->atLeastOnce())->method('logSuccessfulLogin');
        $this->storage->expects($this->atLeastOnce())->method('write')->with($this->identity);
        $this->messenger->expects($this->never())->method('addError');

        $handler = new PostLoginAccountHandler(
            $this->adminService,
            $this->adminLoginService,
            $this->router,
            $this->authenticationService,
            $this->messenger,
            $this->formsPlugin,
            $this->loginForm,
            $this->logger,
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_FOUND, $response->getStatusCode());
    }
}
