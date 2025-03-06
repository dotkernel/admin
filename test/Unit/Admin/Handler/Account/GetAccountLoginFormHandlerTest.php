<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Account;

use Admin\Admin\Form\LoginForm;
use Admin\Admin\Handler\Account\GetAccountLoginFormHandler;
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
        $router                = $this->createMock(RouterInterface::class);
        $template              = $this->createMock(TemplateRendererInterface::class);
        $authenticationService = $this->createMock(AuthenticationServiceInterface::class);
        $messenger             = $this->createMock(FlashMessengerInterface::class);
        $formsPlugin           = $this->createMock(FormsPlugin::class);
        $loginForm             = $this->createMock(LoginForm::class);
        $request               = $this->createMock(ServerRequestInterface::class);

        $authenticationService->method('hasIdentity')->willReturn(true);

        $handler = new GetAccountLoginFormHandler(
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
        $router                = $this->createMock(RouterInterface::class);
        $template              = $this->createMock(TemplateRendererInterface::class);
        $authenticationService = $this->createMock(AuthenticationServiceInterface::class);
        $messenger             = $this->createMock(FlashMessengerInterface::class);
        $formsPlugin           = $this->createMock(FormsPlugin::class);
        $loginForm             = $this->createMock(LoginForm::class);
        $request               = $this->createMock(ServerRequestInterface::class);

        $authenticationService->method('hasIdentity')->willReturn(false);

        $handler = new GetAccountLoginFormHandler(
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
