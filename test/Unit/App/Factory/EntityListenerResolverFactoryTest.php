<?php

declare(strict_types=1);

namespace AdminTest\Unit\App\Factory;

use AdminTest\Unit\UnitTest;
use Core\App\Factory\EntityListenerResolverFactory;
use Core\App\Resolver\EntityListenerResolver;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Container\ContainerInterface;

class EntityListenerResolverFactoryTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testWillInvoke(): void
    {
        $service = (new EntityListenerResolverFactory())(
            $this->createStub(ContainerInterface::class)
        );

        $this->assertSame(EntityListenerResolver::class, $service::class);
    }
}
