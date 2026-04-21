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

        $this->router                = $this->createStub(RouterInterface::class);
        $this->authenticationService = $this->createStub(AuthenticationServiceInterface::class);
    }

    public function testWillCreate(): void
    {
        $handler = new GetIndexRedirectHandler($this->authenticationService, $this->router);

        $this->assertSame(GetIndexRedirectHandler::class, $handler::class);
    }

    /**
     * @throws Exception
     */
    public function testWillReturnRedirectResponse(): void
    {
        $request = $this->createStub(ServerRequestInterface::class);

        $handler = new GetIndexRedirectHandler($this->authenticationService, $this->router);

        $response = $handler->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_FOUND, $response->getStatusCode());
    }
}
