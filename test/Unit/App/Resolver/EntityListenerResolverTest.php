<?php

declare(strict_types=1);

namespace AdminTest\Unit\App\Resolver;

use AdminTest\Unit\UnitTest;
use Core\App\Resolver\EntityListenerResolver;
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
            $this->createStub(ContainerInterface::class)
        );

        $this->assertSame(EntityListenerResolver::class, $resolver::class);
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
                $this->createStub(EntityListenerResolver::class)
            );

        $resolver = new EntityListenerResolver($container);
        $this->assertInstanceOf(
            EntityListenerResolver::class,
            $resolver->resolve(EntityListenerResolver::class)
        );
    }
}
