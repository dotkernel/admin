<?php

declare(strict_types=1);

namespace AdminTest\Unit\Setting;

use Admin\Setting\ConfigProvider;
use Admin\Setting\Handler\GetSettingViewHandler;
use Admin\Setting\Handler\PostSettingStoreHandler;
use Admin\Setting\RoutesDelegator;
use Admin\Setting\Service\SettingService;
use Admin\Setting\Service\SettingServiceInterface;
use AdminTest\Unit\UnitTest;
use Mezzio\Application;

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

    public function testDependenciesHasDelegators(): void
    {
        $this->assertArrayHasKey('delegators', $this->config['dependencies']);
        $this->assertArrayHasKey(Application::class, $this->config['dependencies']['delegators']);
        $this->assertIsArray($this->config['dependencies']['delegators'][Application::class]);
        $this->assertContains(RoutesDelegator::class, $this->config['dependencies']['delegators'][Application::class]);
    }

    public function testDependenciesHasFactories(): void
    {
        $this->assertArrayHasKey('factories', $this->config['dependencies']);
        $this->assertArrayHasKey(PostSettingStoreHandler::class, $this->config['dependencies']['factories']);
        $this->assertArrayHasKey(GetSettingViewHandler::class, $this->config['dependencies']['factories']);
        $this->assertArrayHasKey(SettingService::class, $this->config['dependencies']['factories']);
    }

    public function testDependenciesHasAliases(): void
    {
        $this->assertArrayHasKey('aliases', $this->config['dependencies']);
        $this->assertArrayHasKey(SettingServiceInterface::class, $this->config['dependencies']['aliases']);
    }
}
