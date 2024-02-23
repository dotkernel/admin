<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin;

use Frontend\Admin\Adapter\AuthenticationAdapter;
use Frontend\Admin\ConfigProvider;
use Frontend\Admin\Controller\AdminController;
use Frontend\Admin\Delegator\AdminRoleDelegator;
use Frontend\Admin\Entity\AdminInterface;
use Frontend\Admin\Form\AdminForm;
use Frontend\Admin\Form\ChangePasswordForm;
use Frontend\Admin\Form\LoginForm;
use Frontend\Admin\Service\AdminService;
use Frontend\Admin\Service\AdminServiceInterface;
use FrontendTest\Unit\UnitTest;
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
        $this->assertArrayHasKey(AdminController::class, $this->config['dependencies']['factories']);
        $this->assertArrayHasKey(AdminService::class, $this->config['dependencies']['factories']);
        $this->assertArrayHasKey(AdminForm::class, $this->config['dependencies']['factories']);
        $this->assertArrayHasKey(AuthenticationService::class, $this->config['dependencies']['factories']);
        $this->assertArrayHasKey(AuthenticationAdapter::class, $this->config['dependencies']['factories']);
    }

    public function testDependenciesHasAliases(): void
    {
        $this->assertArrayHasKey('aliases', $this->config['dependencies']);
        $this->assertArrayHasKey(AdminInterface::class, $this->config['dependencies']['aliases']);
        $this->assertArrayHasKey(AdminServiceInterface::class, $this->config['dependencies']['aliases']);
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

    public function testGetDoctrineConfig(): void
    {
        $this->assertArrayHasKey('driver', $this->config['doctrine']);
        $this->assertIsArray($this->config['doctrine']['driver']);
        $this->assertArrayHasKey('orm_default', $this->config['doctrine']['driver']);
        $this->assertIsArray($this->config['doctrine']['driver']['orm_default']);
        $this->assertArrayHasKey('drivers', $this->config['doctrine']['driver']['orm_default']);
        $this->assertArrayHasKey(
            'Frontend\Admin\Entity',
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
