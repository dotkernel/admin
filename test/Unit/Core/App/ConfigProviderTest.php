<?php

declare(strict_types=1);

namespace AdminTest\Unit\Core\App;

use AdminTest\Unit\UnitTest;
use Core\App\ConfigProvider;
use Core\App\Entity\EntityListenerResolver;

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
        $this->assertIsArray($this->config['dependencies']['factories']);
        $this->assertArrayHasKey(EntityListenerResolver::class, $this->config['dependencies']['factories']);
    }
}
