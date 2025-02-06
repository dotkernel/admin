<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Delegator;

use Admin\Admin\Delegator\AdminRoleDelegator;
use Admin\Admin\Form\AdminForm;
use Admin\Admin\Service\AdminRoleServiceInterface;
use AdminTest\Unit\UnitTest;
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
        $container = $this->createMock(ContainerInterface::class);

        $delegator = (new AdminRoleDelegator())(
            $container,
            '',
            function () {
                return new stdClass();
            }
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
        $adminRoleService = $this->createMock(AdminRoleServiceInterface::class);

        $container = $this->createMock(ContainerInterface::class);
        $container
            ->expects($this->once())
            ->method('get')
            ->with(AdminRoleServiceInterface::class)
            ->willReturn($adminRoleService);

        $delegator = (new AdminRoleDelegator())(
            $container,
            '',
            function () {
                return new AdminForm();
            }
        );

        $this->assertInstanceOf(AdminForm::class, $delegator);
    }
}
