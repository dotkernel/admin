<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Setting\Service;

use Frontend\Setting\Repository\SettingRepository;
use Frontend\Setting\Service\SettingService;
use FrontendTest\Unit\UnitTest;
use PHPUnit\Framework\MockObject\Exception;

class SettingServiceTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testWillCreate(): void
    {
        $settingRepository = $this->createMock(SettingRepository::class);

        $service = new SettingService($settingRepository);

        $this->assertInstanceOf(SettingService::class, $service);
    }
}
