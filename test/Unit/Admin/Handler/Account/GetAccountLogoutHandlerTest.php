<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Account;

use Admin\Admin\Handler\Account\GetLogoutAccountHandler;
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
        $router                = $this->createStub(RouterInterface::class);
        $authenticationService = $this->createStub(AuthenticationServiceInterface::class);
        $request               = $this->createStub(ServerRequestInterface::class);

        $handler = new GetLogoutAccountHandler(
            $router,
            $authenticationService,
        );

        $response = $handler->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_FOUND, $response->getStatusCode());
    }
}
