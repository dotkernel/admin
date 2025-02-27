<?php

namespace AdminTest\Unit\Admin\Handler\Account;

use Admin\Admin\Handler\Account\GetAccountLogoutHandler;
use AdminTest\Unit\UnitTest;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use Mezzio\Router\RouterInterface;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Http\Message\ServerRequestInterface;

class GetAccountLogoutHandlerTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testLogoutWillReturnRedirectResponse(): void
    {
        $router = $this->createMock(RouterInterface::class);
        $authenticationService = $this->createMock(AuthenticationServiceInterface::class);
        $request = $this->createMock(ServerRequestInterface::class);

        $handler = new GetAccountLogoutHandler(
            $router,
            $authenticationService,
        );

        $response = $handler->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_FOUND, $response->getStatusCode());
    }
}