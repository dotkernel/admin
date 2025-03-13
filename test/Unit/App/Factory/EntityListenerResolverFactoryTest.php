<?php

declare(strict_types=1);

namespace AdminTest\Unit\App\Factory;

use AdminTest\Unit\UnitTest;
use Core\App\Entity\EntityListenerResolver;
use Core\App\Factory\EntityListenerResolverFactory;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Container\ContainerInterface;

class EntityListenerResolverFactoryTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testWillInvoke(): void
    {
        $container = $this->createMock(ContainerInterface::class);

        $service = (new EntityListenerResolverFactory())($container);
        $this->assertInstanceOf(EntityListenerResolver::class, $service);
    }
}
