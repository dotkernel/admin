<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Setting;

use Frontend\Setting\ConfigProvider;
use Frontend\Setting\Controller\SettingController;
use Frontend\Setting\Repository\SettingRepository;
use Frontend\Setting\Service\SettingService;
use FrontendTest\Unit\UnitTest;

class ConfigProviderTest extends UnitTest
{
    protected array $config = [];

    protected function setup(): void
    {
        parent::setUp();

        $this->config = (new ConfigProvider())();
    }

    public function testConfigHasDependencies(): void
    {
        $this->assertArrayHasKey('dependencies', $this->config);
    }

    public function testDependenciesHasFactories(): void
    {
        $this->assertArrayHasKey('factories', $this->config['dependencies']);
        $this->assertArrayHasKey(SettingController::class, $this->config['dependencies']['factories']);
        $this->assertArrayHasKey(SettingService::class, $this->config['dependencies']['factories']);
        $this->assertArrayHasKey(SettingRepository::class, $this->config['dependencies']['factories']);
    }

    public function testGetDoctrineConfig(): void
    {
        $this->assertArrayHasKey('driver', $this->config['doctrine']);
        $this->assertIsArray($this->config['doctrine']['driver']);
        $this->assertArrayHasKey('orm_default', $this->config['doctrine']['driver']);
        $this->assertIsArray($this->config['doctrine']['driver']['orm_default']);
        $this->assertArrayHasKey('drivers', $this->config['doctrine']['driver']['orm_default']);
        $this->assertArrayHasKey(
            'Frontend\Setting\Entity',
            $this->config['doctrine']['driver']['orm_default']['drivers']
        );
        $this->assertArrayHasKey('SettingEntities', $this->config['doctrine']['driver']);
        $this->assertIsArray($this->config['doctrine']['driver']['SettingEntities']);
        $this->assertArrayHasKey('class', $this->config['doctrine']['driver']['SettingEntities']);
        $this->assertIsString($this->config['doctrine']['driver']['SettingEntities']['class']);
        $this->assertNotEmpty($this->config['doctrine']['driver']['SettingEntities']['class']);
        $this->assertArrayHasKey('cache', $this->config['doctrine']['driver']['SettingEntities']);
        $this->assertIsString($this->config['doctrine']['driver']['SettingEntities']['cache']);
        $this->assertNotEmpty($this->config['doctrine']['driver']['SettingEntities']['cache']);
        $this->assertArrayHasKey('paths', $this->config['doctrine']['driver']['SettingEntities']);
        $this->assertIsArray($this->config['doctrine']['driver']['SettingEntities']['paths']);
        $this->assertNotEmpty($this->config['doctrine']['driver']['SettingEntities']['paths']);
    }
}
