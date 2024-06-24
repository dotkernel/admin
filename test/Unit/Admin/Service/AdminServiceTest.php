<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\Service;

use Doctrine\ORM\Exception\NotSupported;
use Dot\GeoIP\Service\LocationServiceInterface;
use Frontend\Admin\Repository\AdminRepository;
use Frontend\Admin\Repository\AdminRoleRepository;
use Frontend\Admin\Service\AdminService;
use Frontend\Admin\Service\AdminServiceInterface;
use FrontendTest\Unit\UnitTest;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class AdminServiceTest extends UnitTest
{
    /**
     * @throws ContainerExceptionInterface
     * @throws Exception
     * @throws NotFoundExceptionInterface
     * @throws NotSupported
     */
    public function testWillCreate(): void
    {
        $adminRepository     = $this->createMock(AdminRepository::class);
        $adminRoleRepository = $this->createMock(AdminRoleRepository::class);

        $service = new AdminService(
            $this->createMock(LocationServiceInterface::class),
            $adminRepository,
            $adminRoleRepository,
            0
        );

        $this->assertInstanceOf(AdminServiceInterface::class, $service);
    }
}
