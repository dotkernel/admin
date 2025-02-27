<?php

namespace AdminTest\Unit\Admin\Handler\Account;

use Admin\Admin\Adapter\AuthenticationAdapter;
use Admin\Admin\Entity\AdminIdentity;
use Admin\Admin\Entity\AdminLogin;
use Admin\Admin\Form\LoginForm;
use Admin\Admin\Handler\Account\PostAccountLoginHandler;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Message;
use Admin\App\Plugin\FormsPlugin;
use AdminTest\Unit\UnitTest;
use Dot\Authentication\AuthenticationResult;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Log\Logger;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Authentication\Result;
use Mezzio\Router\RouterInterface;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Http\Message\ServerRequestInterface;

class PostAccountLoginHandlerTest extends UnitTest
{
    private AdminServiceInterface $adminService;
    private RouterInterface $router;
    private AuthenticationService $authenticationService;
    private FlashMessengerInterface $messenger;
    private FormsPlugin $formsPlugin;
    private LoginForm $loginForm;
    private Logger $logger;
    private ServerRequestInterface $request;
    private Result $authenticationResult;
    private AuthenticationAdapter $authenticationAdapter;


    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->adminService = $this->createMock(AdminServiceInterface::class);
        $this->router = $this->createMock(RouterInterface::class);
        $this->authenticationService = $this->createMock(AuthenticationService::class);
        $this->messenger = $this->createMock(FlashMessengerInterface::class);
        $this->formsPlugin = $this->createMock(FormsPlugin::class);
        $this->loginForm = $this->createMock(LoginForm::class);
        $this->request = $this->createMock(ServerRequestInterface::class);
        $this->authenticationResult = $this->createMock(Result::class);
        $this->authenticationAdapter = $this->createMock(AuthenticationAdapter::class);
        $this->logger          = new Logger([
            'writers' => [
                'FileWriter' => [
                    'name'     => 'null',
                    'priority' => Logger::ALERT,
                ],
            ],
        ]);
    }

//    public function testAdminAlreadyLoggedWillReturnRedirectResponse(): void
//    {
//        $this->authenticationService->method('hasIdentity')->willReturn(true);
//
//        $handler = new PostAccountLoginHandler(
//            $this->adminService,
//            $this->router,
//            $this->authenticationService,
//            $this->messenger,
//            $this->formsPlugin,
//            $this->loginForm,
//            $this->logger,
//        );
//
//        $response = $handler->handle($this->request);
//
//        $this->assertSame(StatusCodeInterface::STATUS_FOUND, $response->getStatusCode());
//    }
//
//    public function testInvalidLoginFormDataProvidedWillReturnRedirectResponse(): void
//    {
//        $this->authenticationService->method('hasIdentity')->willReturn(false);
//        $this->request->method('getParsedBody')->willReturn(['test']);
//        $this->loginForm->method('isValid')->willReturn(false);
//
//        $this
//            ->messenger
//            ->expects($this->exactly(1))
//            ->method('addError');
//
//        $handler = new PostAccountLoginHandler(
//            $this->adminService,
//            $this->router,
//            $this->authenticationService,
//            $this->messenger,
//            $this->formsPlugin,
//            $this->loginForm,
//            $this->logger,
//        );
//
//        $response = $handler->handle($this->request);
//
//        $this->assertSame(StatusCodeInterface::STATUS_SEE_OTHER, $response->getStatusCode());
//    }

    /**
     * @throws Exception
     */
    public function testInvalidPasswordProvidedWillReturnRedirectResponse(): void
    {
        $this->authenticationResult->method('isValid')->willReturn(false);
        $this->authenticationResult->method('getMessages')->willReturn([]);
        $this->authenticationService->method('authenticate')->willReturn($this->authenticationResult);
        $this->authenticationService->method('hasIdentity')->willReturn(false);
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->request->method('getServerParams')->willReturn([]);
        $this->loginForm->method('isValid')->willReturn(true);
        $this->loginForm->method('getData')->willReturn(['username' => 'test', 'password' => 'test']);
        $this->authenticationAdapter->method('setIdentity')->willReturn($this->authenticationAdapter);
        $this->authenticationAdapter->method('setCredential')->willReturn($this->authenticationAdapter);
        $this->authenticationService->method('getAdapter')->willReturn($this->authenticationAdapter);

        $this->messenger->expects($this->exactly(1))->method('addError');
        $this->adminService->expects($this->exactly(1))->method('logAdminVisit');

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
}