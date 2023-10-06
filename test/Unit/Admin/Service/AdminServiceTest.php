<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\NotSupported;
use Dot\GeoIP\Service\LocationServiceInterface;
use Dot\UserAgentSniffer\Service\DeviceServiceInterface;
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
        /** @var EntityManager $entityManager */
        $entityManager = $this->getContainer()->get(EntityManager::class);

        $service = new AdminService(
            $this->createMock(LocationServiceInterface::class),
            $this->createMock(DeviceServiceInterface::class),
            $entityManager,
            0
        );

        $this->assertInstanceOf(AdminServiceInterface::class, $service);
    }
}
