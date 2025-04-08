<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin;

use Admin\Admin\Adapter\AuthenticationAdapter;
use Admin\Admin\ConfigProvider;
use Admin\Admin\Delegator\AdminRoleDelegator;
use Admin\Admin\Form\CreateAdminForm;
use AdminTest\Unit\UnitTest;
use Laminas\Authentication\AuthenticationService;

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

    public function testConfigHasTemplates(): void
    {
        $this->assertArrayHasKey('templates', $this->config);
    }

    public function testDependenciesHasFactories(): void
    {
        $this->assertArrayHasKey('factories', $this->config['dependencies']);
        $this->assertArrayHasKey(CreateAdminForm::class, $this->config['dependencies']['factories']);
        $this->assertArrayHasKey(AuthenticationService::class, $this->config['dependencies']['factories']);
        $this->assertArrayHasKey(AuthenticationAdapter::class, $this->config['dependencies']['factories']);
    }

    public function testDependenciesHasDelegators(): void
    {
        $this->assertArrayHasKey('delegators', $this->config['dependencies']);
        $this->assertArrayHasKey(CreateAdminForm::class, $this->config['dependencies']['delegators']);
        $this->assertIsArray($this->config['dependencies']['delegators'][CreateAdminForm::class]);
        $this->assertContainsEquals(
            AdminRoleDelegator::class,
            $this->config['dependencies']['delegators'][CreateAdminForm::class]
        );
    }

    public function testGetTemplates(): void
    {
        $this->assertArrayHasKey('paths', $this->config['templates']);
        $this->assertIsArray($this->config['templates']['paths']);
        $this->assertArrayHasKey('admin', $this->config['templates']['paths']);
    }
}
