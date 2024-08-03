<?php

declare(strict_types=1);

namespace AdminTest\Unit\Setting\Service;

use Admin\Setting\Repository\SettingRepository;
use Admin\Setting\Service\SettingService;
use AdminTest\Unit\UnitTest;
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
