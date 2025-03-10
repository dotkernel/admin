<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Account;

use Admin\Admin\Adapter\AuthenticationAdapter;
use Admin\Admin\Entity\AdminIdentity;
use Admin\Admin\Enum\AdminStatusEnum;
use Admin\Admin\Form\LoginForm;
use Admin\Admin\Handler\Account\PostAccountLoginHandler;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Message;
use Admin\App\Plugin\FormsPlugin;
use AdminTest\Unit\UnitTest;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Log\Logger;
use Exception;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\Result;
use Laminas\Authentication\Storage\StorageInterface;
use Mezzio\Router\RouterInterface;
use PHPUnit\Framework\MockObject\Exception as MockObjectException;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

class PostAccountLoginHandlerTest extends UnitTest
{
    private MockObject|AdminServiceInterface $adminService;
    private MockObject|RouterInterface $router;
    private MockObject|AuthenticationService $authenticationService;
    private MockObject|FlashMessengerInterface $messenger;
    private MockObject|FormsPlugin $formsPlugin;
    private MockObject|LoginForm $loginForm;
    private Logger $logger;
    private MockObject|ServerRequestInterface $request;
    private MockObject|Result $authenticationResult;
    private MockObject|AuthenticationAdapter $authenticationAdapter;
    private MockObject|AdminIdentity $identity;
    private MockObject|StorageInterface $storage;

    /**
     * @throws MockObjectException
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->adminService          = $this->createMock(AdminServiceInterface::class);
        $this->router                = $this->createMock(RouterInterface::class);
        $this->authenticationService = $this->createMock(AuthenticationService::class);
        $this->messenger             = $this->createMock(FlashMessengerInterface::class);
        $this->formsPlugin           = $this->createMock(FormsPlugin::class);
        $this->loginForm             = $this->createMock(LoginForm::class);
        $this->request               = $this->createMock(ServerRequestInterface::class);
        $this->authenticationResult  = $this->createMock(Result::class);
        $this->authenticationAdapter = $this->createMock(AuthenticationAdapter::class);
        $this->identity              = $this->createMock(AdminIdentity::class);
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
        $this->authenticationService->method('hasIdentity')->willReturn(true);

        $handler = new PostAccountLoginHandler(
            $this->adminService,
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
        $this->authenticationService->method('hasIdentity')->willReturn(false);
        $this->loginForm->method('isValid')->willReturn(false);
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->request->method('getQueryParams')->willReturn([]);
        $this->request->method('getServerParams')->willReturn([]);
        $this->request->method('getUri')->willReturn(
            $this->createMock(UriInterface::class)
        );

        $this
            ->messenger
            ->expects($this->atLeastOnce())
            ->method('addError');

        $handler = new PostAccountLoginHandler(
            $this->adminService,
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
     * @throws Exception
     * @throws MockObjectException
     */
    public function testInvalidPasswordProvidedWillReturnRedirectResponse(): void
    {
        $this->authenticationResult->method('isValid')->willReturn(false);
        $this->authenticationResult->method('getMessages')->willReturn([]);
        $this->authenticationService->method('authenticate')->willReturn($this->authenticationResult);
        $this->authenticationService->method('hasIdentity')->willReturn(false);
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->request->method('getServerParams')->willReturn([]);
        $this->request->method('getUri')->willReturn($this->createMock(UriInterface::class));
        $this->loginForm->method('isValid')->willReturn(true);
        $this->loginForm->method('getData')->willReturn(['username' => 'test', 'password' => 'test']);
        $this->authenticationAdapter->method('setIdentity')->willReturn($this->authenticationAdapter);
        $this->authenticationAdapter->method('setCredential')->willReturn($this->authenticationAdapter);
        $this->authenticationService->method('getAdapter')->willReturn($this->authenticationAdapter);

        $this->messenger->expects($this->atLeastOnce())->method('addError');
        $this->adminService->expects($this->atLeastOnce())->method('logAdminVisit');

        $handler = new PostAccountLoginHandler(
            $this->adminService,
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

    public function testAdminInactiveWillReturnRedirectResponse(): void
    {
        $this->identity->method('getStatus')->willReturn(AdminStatusEnum::Inactive);
        $this->authenticationResult->method('isValid')->willReturn(true);
        $this->authenticationResult->method('getMessages')->willReturn([]);
        $this->authenticationResult->method('getIdentity')->willReturn($this->identity);
        $this->authenticationService->method('authenticate')->willReturn($this->authenticationResult);
        $this->authenticationService->method('hasIdentity')->willReturn(false);
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->request->method('getServerParams')->willReturn([]);
        $this->loginForm->method('isValid')->willReturn(true);
        $this->loginForm->method('getData')->willReturn(['username' => 'test', 'password' => 'test']);
        $this->authenticationAdapter->method('setIdentity')->willReturn($this->authenticationAdapter);
        $this->authenticationAdapter->method('setCredential')->willReturn($this->authenticationAdapter);
        $this->authenticationService->method('getAdapter')->willReturn($this->authenticationAdapter);

        $this
            ->authenticationService
            ->expects($this->atLeastOnce())
            ->method('clearIdentity');

        $handler = new PostAccountLoginHandler(
            $this->adminService,
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
        $this->request->method('getUri')->willReturn($this->createMock(UriInterface::class));
        $this->throwException(new Exception());

        $this
            ->messenger
            ->expects($this->atLeastOnce())
            ->method('addError')
            ->with(Message::AN_ERROR_OCCURRED);

        $handler = new PostAccountLoginHandler(
            $this->adminService,
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

    public function testAdminLoginSuccessfulWillReturnRedirectResponse(): void
    {
        $this->identity->method('getStatus')->willReturn(AdminStatusEnum::Active);
        $this->authenticationResult->method('isValid')->willReturn(true);
        $this->authenticationResult->method('getMessages')->willReturn([]);
        $this->authenticationResult->method('getIdentity')->willReturn($this->identity);
        $this->authenticationService->method('authenticate')->willReturn($this->authenticationResult);
        $this->authenticationService->method('hasIdentity')->willReturn(false);
        $this->authenticationService->method('getStorage')->willReturn($this->storage);
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->request->method('getServerParams')->willReturn([]);
        $this->loginForm->method('isValid')->willReturn(true);
        $this->loginForm->method('getData')->willReturn(['username' => 'test', 'password' => 'test']);
        $this->authenticationAdapter->method('setIdentity')->willReturn($this->authenticationAdapter);
        $this->authenticationAdapter->method('setCredential')->willReturn($this->authenticationAdapter);
        $this->authenticationService->method('getAdapter')->willReturn($this->authenticationAdapter);

        $this->adminService->expects($this->atLeastOnce())->method('logAdminVisit');
        $this->storage->expects($this->atLeastOnce())->method('write')->with($this->identity);

        $handler = new PostAccountLoginHandler(
            $this->adminService,
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
