<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\Delegator;

use Frontend\Admin\Delegator\AdminRoleDelegator;
use Frontend\Admin\Form\AdminForm;
use Frontend\Admin\Service\AdminService;
use FrontendTest\Unit\UnitTest;
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
        $adminService = $this->createMock(AdminService::class);

        $container = $this->createMock(ContainerInterface::class);
        $container
            ->expects($this->once())
            ->method('get')
            ->with(AdminService::class)
            ->willReturn($adminService);

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
