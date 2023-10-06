<?php

declare(strict_types=1);

namespace FrontendTest\Unit\App\Middleware;

use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Rbac\Guard\Exception\RuntimeException;
use Dot\Rbac\Guard\Guard\GuardInterface;
use Dot\Rbac\Guard\Options\RbacGuardOptions;
use Dot\Rbac\Guard\Provider\GuardsProviderInterface;
use Frontend\App\Middleware\AuthMiddleware;
use FrontendTest\Unit\UnitTest;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Http\Response;
use Mezzio\Router\RouterInterface;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function sprintf;

class AuthMiddlewareTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testWillCreate(): void
    {
        $authMiddleware = new AuthMiddleware(
            $this->createMock(RouterInterface::class),
            $this->createMock(FlashMessengerInterface::class),
            $this->createMock(GuardsProviderInterface::class),
            new RbacGuardOptions([])
        );
        $this->assertInstanceOf(AuthMiddleware::class, $authMiddleware);
    }

    /**
     * @throws Exception
     */
    public function testWillRedirectWhenNotGranted(): void
    {
        $rbacGuardOptions = new RbacGuardOptions([]);
        $rbacGuardOptions->setProtectionPolicy(GuardInterface::POLICY_DENY);

        $authMiddleware = new AuthMiddleware(
            $this->createMock(RouterInterface::class),
            $this->createMock(FlashMessengerInterface::class),
            $this->createMock(GuardsProviderInterface::class),
            $rbacGuardOptions
        );

        $response = $authMiddleware->process(
            $this->createMock(ServerRequestInterface::class),
            $this->createMock(RequestHandlerInterface::class)
        );
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertTrue($response->hasHeader('location'));
        $this->assertEquals(Response::STATUS_CODE_302, $response->getStatusCode());
    }

    /**
     * @throws Exception
     */
    public function testWillProcessWithoutGuards(): void
    {
        $authMiddleware = new AuthMiddleware(
            $this->createMock(RouterInterface::class),
            $this->createMock(FlashMessengerInterface::class),
            $this->createMock(GuardsProviderInterface::class),
            new RbacGuardOptions([])
        );

        $response = $authMiddleware->process(
            $this->createMock(ServerRequestInterface::class),
            $this->createMock(RequestHandlerInterface::class)
        );
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    /**
     * @throws Exception
     */
    public function testWillProcessWithGuardsAndFailOnInvalidGuard(): void
    {
        $guardsProvider = $this->createMock(GuardsProviderInterface::class);
        $guardsProvider
            ->expects($this->once())
            ->method('getGuards')
            ->willReturn(['test']);

        $authMiddleware = new AuthMiddleware(
            $this->createMock(RouterInterface::class),
            $this->createMock(FlashMessengerInterface::class),
            $guardsProvider,
            new RbacGuardOptions([])
        );

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(
            sprintf('Guard is not an instance of %s', GuardInterface::class)
        );
        $authMiddleware->process(
            $this->createMock(ServerRequestInterface::class),
            $this->createMock(RequestHandlerInterface::class)
        );
    }

    /**
     * @throws Exception
     */
    public function testWillProcessWithGuardsAndFailIfGuardDeniesAccess(): void
    {
        $guardsProvider = $this->createMock(GuardsProviderInterface::class);
        $guardsProvider
            ->expects($this->once())
            ->method('getGuards')
            ->willReturn([
                new class implements GuardInterface {
                    public function isGranted(ServerRequestInterface $request): bool
                    {
                        return false;
                    }

                    public function getPriority(): int
                    {
                        return 1;
                    }
                },
            ]);

        $authMiddleware = new AuthMiddleware(
            $this->createMock(RouterInterface::class),
            $this->createMock(FlashMessengerInterface::class),
            $guardsProvider,
            new RbacGuardOptions([])
        );

        $response = $authMiddleware->process(
            $this->createMock(ServerRequestInterface::class),
            $this->createMock(RequestHandlerInterface::class)
        );
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertTrue($response->hasHeader('location'));
        $this->assertEquals(Response::STATUS_CODE_302, $response->getStatusCode());
    }

    /**
     * @throws Exception
     */
    public function testWillProcessWithGuardsWhenGuardGrantsAccess(): void
    {
        $guardsProvider = $this->createMock(GuardsProviderInterface::class);
        $guardsProvider
            ->expects($this->once())
            ->method('getGuards')
            ->willReturn([
                new class implements GuardInterface {
                    public function isGranted(ServerRequestInterface $request): bool
                    {
                        return true;
                    }

                    public function getPriority(): int
                    {
                        return 1;
                    }
                },
            ]);

        $authMiddleware = new AuthMiddleware(
            $this->createMock(RouterInterface::class),
            $this->createMock(FlashMessengerInterface::class),
            $guardsProvider,
            new RbacGuardOptions([])
        );

        $response = $authMiddleware->process(
            $this->createMock(ServerRequestInterface::class),
            $this->createMock(RequestHandlerInterface::class)
        );
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }
}
