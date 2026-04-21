<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Account;

use Admin\Admin\Form\LoginForm;
use Admin\Admin\Handler\Account\GetLoginAccountFormHandler;
use Admin\App\Plugin\FormsPlugin;
use AdminTest\Unit\UnitTest;
use Dot\FlashMessenger\FlashMessengerInterface;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Http\Message\ServerRequestInterface;

class GetAccountLoginFormHandlerTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testAdminLoggedWillReturnRedirectResponse(): void
    {
        $router                = $this->createStub(RouterInterface::class);
        $template              = $this->createStub(TemplateRendererInterface::class);
        $authenticationService = $this->createStub(AuthenticationServiceInterface::class);
        $messenger             = $this->createStub(FlashMessengerInterface::class);
        $formsPlugin           = $this->createStub(FormsPlugin::class);
        $loginForm             = $this->createStub(LoginForm::class);
        $request               = $this->createStub(ServerRequestInterface::class);

        $authenticationService->method('hasIdentity')->willReturn(true);

        $handler = new GetLoginAccountFormHandler(
            $router,
            $template,
            $authenticationService,
            $messenger,
            $formsPlugin,
            $loginForm,
        );

        $response = $handler->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_FOUND, $response->getStatusCode());
    }

    /**
     * @throws Exception
     */
    public function testWillReturnHtmlResponse(): void
    {
        $router                = $this->createStub(RouterInterface::class);
        $template              = $this->createStub(TemplateRendererInterface::class);
        $authenticationService = $this->createStub(AuthenticationServiceInterface::class);
        $messenger             = $this->createStub(FlashMessengerInterface::class);
        $formsPlugin           = $this->createStub(FormsPlugin::class);
        $loginForm             = $this->createStub(LoginForm::class);
        $request               = $this->createStub(ServerRequestInterface::class);

        $authenticationService->method('hasIdentity')->willReturn(false);

        $handler = new GetLoginAccountFormHandler(
            $router,
            $template,
            $authenticationService,
            $messenger,
            $formsPlugin,
            $loginForm,
        );

        $response = $handler->handle($request);

        $this->assertSame($response->getHeader('content-type')[0], 'text/html; charset=utf-8');
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
