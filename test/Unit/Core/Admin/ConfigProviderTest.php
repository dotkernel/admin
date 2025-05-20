<?php

declare(strict_types=1);

namespace AdminTest\Unit\Core\Admin;

use AdminTest\Unit\UnitTest;
use Core\Admin\ConfigProvider;
use Core\Admin\DBAL\Types\AdminRoleEnumType;
use Core\Admin\DBAL\Types\AdminStatusEnumType;
use Core\Admin\Repository\AdminLoginRepository;
use Core\Admin\Repository\AdminRepository;
use Core\Admin\Repository\AdminRoleRepository;

/**
 * @phpstan-import-type ConfigType from ConfigProvider
 */
class ConfigProviderTest extends UnitTest
{
    /** @phpstan-var ConfigType $config */
    protected array $config;

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
        $this->assertArrayHasKey(AdminRepository::class, $this->config['dependencies']['factories']);
        $this->assertArrayHasKey(AdminLoginRepository::class, $this->config['dependencies']['factories']);
        $this->assertArrayHasKey(AdminRoleRepository::class, $this->config['dependencies']['factories']);
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
        $this->assertArrayHasKey('types', $this->config['doctrine']);
        $this->assertIsArray($this->config['doctrine']['types']);
        $this->assertArrayHasKey(AdminRoleEnumType::NAME, $this->config['doctrine']['types']);
        $this->assertSame(AdminRoleEnumType::class, $this->config['doctrine']['types'][AdminRoleEnumType::NAME]);
        $this->assertArrayHasKey(AdminStatusEnumType::NAME, $this->config['doctrine']['types']);
        $this->assertSame(AdminStatusEnumType::class, $this->config['doctrine']['types'][AdminStatusEnumType::NAME]);
    }
}
