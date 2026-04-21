<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Delegator;

use Admin\Admin\Delegator\AdminRoleDelegator;
use Admin\Admin\Form\CreateAdminForm;
use AdminTest\Unit\UnitTest;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use stdClass;

class AdminRoleDelegatorTest extends UnitTest
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function testInvokeWillSucceedWithoutAdminForm(): void
    {
        $container = $this->createStub(ContainerInterface::class);

        $delegator = (new AdminRoleDelegator())(
            $container,
            '',
            fn () => new stdClass()
        );

        $this->assertIsObject($delegator);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function testInvokeWillSucceedWithAdminForm(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $container
            ->expects($this->once())
            ->method('get')
            ->with(EntityManagerInterface::class)
            ->willReturn(
                $this->createStub(EntityManagerInterface::class)
            );

        $delegator = (new AdminRoleDelegator())(
            $container,
            '',
            fn () => new CreateAdminForm()
        );

        $this->assertInstanceOf(CreateAdminForm::class, $delegator);
    }
}
