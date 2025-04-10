<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Service;

use Admin\Admin\Service\AdminService;
use Admin\Admin\Service\AdminServiceInterface;
use AdminTest\Unit\UnitTest;
use Core\Admin\Repository\AdminRepository;
use Core\Admin\Repository\AdminRoleRepository;
use Doctrine\ORM\Exception\NotSupported;
use PHPUnit\Framework\MockObject\Exception;

class AdminServiceTest extends UnitTest
{
    /**
     * @throws Exception
     * @throws NotSupported
     */
    public function testWillCreate(): void
    {
        $adminRepository     = $this->createMock(AdminRepository::class);
        $adminRoleRepository = $this->createMock(AdminRoleRepository::class);

        $service = new AdminService($adminRepository, $adminRoleRepository);

        $this->assertContainsOnlyInstancesOf(AdminServiceInterface::class, [$service]);
    }
}
