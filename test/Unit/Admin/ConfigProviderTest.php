<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin;

use Admin\Admin\Adapter\AuthenticationAdapter;
use Admin\Admin\ConfigProvider;
use Admin\Admin\Delegator\AdminRoleDelegator;
use Admin\Admin\Form\AdminForm;
use Admin\Admin\Form\ChangePasswordForm;
use Admin\Admin\Form\LoginForm;
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

    public function testConfigHasDotForm(): void
    {
        $this->assertArrayHasKey('form', $this->config);
    }

    public function testDependenciesHasFactories(): void
    {
        $this->assertArrayHasKey('factories', $this->config['dependencies']);
        $this->assertArrayHasKey(AdminForm::class, $this->config['dependencies']['factories']);
        $this->assertArrayHasKey(AuthenticationService::class, $this->config['dependencies']['factories']);
        $this->assertArrayHasKey(AuthenticationAdapter::class, $this->config['dependencies']['factories']);
    }

    public function testDependenciesHasDelegators(): void
    {
        $this->assertArrayHasKey('delegators', $this->config['dependencies']);
        $this->assertArrayHasKey(AdminForm::class, $this->config['dependencies']['delegators']);
        $this->assertIsArray($this->config['dependencies']['delegators'][AdminForm::class]);
        $this->assertContainsEquals(
            AdminRoleDelegator::class,
            $this->config['dependencies']['delegators'][AdminForm::class]
        );
    }

    public function testGetTemplates(): void
    {
        $this->assertArrayHasKey('paths', $this->config['templates']);
        $this->assertIsArray($this->config['templates']['paths']);
        $this->assertArrayHasKey('admin', $this->config['templates']['paths']);
    }

    public function testGetForms(): void
    {
        $this->assertArrayHasKey('form_manager', $this->config['form']);
        $this->assertIsArray($this->config['form']['form_manager']);
        $this->assertArrayHasKey('factories', $this->config['form']['form_manager']);
        $this->assertArrayHasKey(LoginForm::class, $this->config['form']['form_manager']['factories']);
        $this->assertArrayHasKey(ChangePasswordForm::class, $this->config['form']['form_manager']['factories']);
        $this->assertArrayHasKey('aliases', $this->config['form']['form_manager']);
        $this->assertArrayHasKey('delegators', $this->config['form']['form_manager']);
    }
}
