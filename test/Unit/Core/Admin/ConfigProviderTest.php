<?php

declare(strict_types=1);

namespace AdminTest\Unit\Core\Admin;

use AdminTest\Unit\UnitTest;
use Core\Admin\ConfigProvider;
use Core\Admin\Entity\AdminInterface;
use Core\Admin\Service\AdminService;
use Core\Admin\Service\AdminServiceInterface;

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
        $this->assertArrayHasKey(AdminService::class, $this->config['dependencies']['factories']);
    }

    public function testDependenciesHasAliases(): void
    {
        $this->assertArrayHasKey('aliases', $this->config['dependencies']);
        $this->assertArrayHasKey(AdminInterface::class, $this->config['dependencies']['aliases']);
        $this->assertArrayHasKey(AdminServiceInterface::class, $this->config['dependencies']['aliases']);
    }

    public function testGetDoctrineConfig(): void
    {
        $this->assertArrayHasKey('driver', $this->config['doctrine']);
        $this->assertIsArray($this->config['doctrine']['driver']);
        $this->assertArrayHasKey('orm_default', $this->config['doctrine']['driver']);
        $this->assertIsArray($this->config['doctrine']['driver']['orm_default']);
        $this->assertArrayHasKey('drivers', $this->config['doctrine']['driver']['orm_default']);
        $this->assertArrayHasKey(
            'Core\Admin\Entity',
            $this->config['doctrine']['driver']['orm_default']['drivers']
        );
        $this->assertArrayHasKey('AdminEntities', $this->config['doctrine']['driver']);
        $this->assertIsArray($this->config['doctrine']['driver']['AdminEntities']);
        $this->assertArrayHasKey('class', $this->config['doctrine']['driver']['AdminEntities']);
        $this->assertIsString($this->config['doctrine']['driver']['AdminEntities']['class']);
        $this->assertNotEmpty($this->config['doctrine']['driver']['AdminEntities']['class']);
        $this->assertArrayHasKey('cache', $this->config['doctrine']['driver']['AdminEntities']);
        $this->assertIsString($this->config['doctrine']['driver']['AdminEntities']['cache']);
        $this->assertNotEmpty($this->config['doctrine']['driver']['AdminEntities']['cache']);
        $this->assertArrayHasKey('paths', $this->config['doctrine']['driver']['AdminEntities']);
        $this->assertIsArray($this->config['doctrine']['driver']['AdminEntities']['paths']);
        $this->assertNotEmpty($this->config['doctrine']['driver']['AdminEntities']['paths']);
    }
}
