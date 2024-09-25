<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Service;

use Admin\Admin\Repository\AdminLoginRepository;
use Admin\Admin\Repository\AdminRepository;
use Admin\Admin\Repository\AdminRoleRepository;
use Admin\Admin\Service\AdminService;
use Admin\Admin\Service\AdminServiceInterface;
use AdminTest\Unit\UnitTest;
use Doctrine\ORM\Exception\NotSupported;
use Dot\GeoIP\Service\LocationServiceInterface;
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
        $adminRepository      = $this->createMock(AdminRepository::class);
        $adminRoleRepository  = $this->createMock(AdminRoleRepository::class);
        $adminLoginRepository = $this->createMock(AdminLoginRepository::class);

        $service = new AdminService(
            $this->createMock(LocationServiceInterface::class),
            $adminRepository,
            $adminRoleRepository,
            $adminLoginRepository
        );

        $this->assertInstanceOf(AdminServiceInterface::class, $service);
    }
}
