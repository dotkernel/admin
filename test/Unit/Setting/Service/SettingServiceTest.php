<?php

declare(strict_types=1);

namespace AdminTest\Unit\Setting\Service;

use Admin\Setting\Service\SettingService;
use AdminTest\Unit\UnitTest;
use Core\Setting\Repository\SettingRepository;
use PHPUnit\Framework\MockObject\Exception;

class SettingServiceTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testWillCreate(): void
    {
        $settingRepository = $this->createStub(SettingRepository::class);

        $service = new SettingService($settingRepository);

        $this->assertSame(SettingService::class, $service::class);
    }
}
