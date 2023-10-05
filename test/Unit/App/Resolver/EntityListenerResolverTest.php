<?php

declare(strict_types=1);

namespace FrontendTest\Unit\App\Resolver;

use Frontend\App\Resolver\EntityListenerResolver;
use FrontendTest\Unit\UnitTest;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use stdClass;

class EntityListenerResolverTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testWillCreate(): void
    {
        $resolver = new EntityListenerResolver(
            $this->createMock(ContainerInterface::class)
        );
        $this->assertInstanceOf(EntityListenerResolver::class, $resolver);
    }

    /**
     * @throws Exception
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testWillResolveNonExistingItem(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $container
            ->expects($this->once())
            ->method('get')
            ->with('test')
            ->willReturn(
                new stdClass()
            );

        $resolver = new EntityListenerResolver($container);
        $this->assertIsObject(
            $resolver->resolve('test')
        );
    }

    /**
     * @throws Exception
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testWillResolveExistingItem(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $container
            ->expects($this->once())
            ->method('get')
            ->with(EntityListenerResolver::class)
            ->willReturn(
                $this->createMock(EntityListenerResolver::class)
            );

        $resolver = new EntityListenerResolver($container);
        $this->assertInstanceOf(
            EntityListenerResolver::class,
            $resolver->resolve(EntityListenerResolver::class)
        );
    }
}
