<?php

declare(strict_types=1);

namespace AdminTest\Unit\App\Handler;

use Admin\App\Handler\GetIndexRedirectHandler;
use AdminTest\Unit\UnitTest;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use Mezzio\Router\RouterInterface;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Http\Message\ServerRequestInterface;

class GetIndexRedirectHandlerTest extends UnitTest
{
    private RouterInterface $router;
    private AuthenticationServiceInterface $authenticationService;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->router                = $this->createMock(RouterInterface::class);
        $this->authenticationService = $this->createMock(AuthenticationServiceInterface::class);
    }

    public function testWillCreate(): void
    {
        $handler = new GetIndexRedirectHandler($this->router, $this->authenticationService);

        $this->assertInstanceOf(GetIndexRedirectHandler::class, $handler);
    }

    /**
     * @throws Exception
     */
    public function testWillReturnRedirectResponse(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);

        $handler = new GetIndexRedirectHandler($this->router, $this->authenticationService);

        $response = $handler->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_FOUND, $response->getStatusCode());
    }
}
