<?php

declare(strict_types=1);

namespace FrontendTest\Unit\App;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Dot\Controller\Plugin\PluginManager;
use Frontend\Admin\RoutesDelegator as AdminDelegator;
use Frontend\App\ConfigProvider;
use Frontend\App\Controller\DashboardController;
use Frontend\App\Plugin\FormsPlugin;
use Frontend\App\Resolver\EntityListenerResolver;
use Frontend\App\RoutesDelegator as AppDelegator;
use FrontendTest\Unit\UnitTest;
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

    public function testConfigHasTemplates(): void
    {
        $this->assertArrayHasKey('templates', $this->config);
    }

    public function testDependenciesHasDelegators(): void
    {
        $this->assertArrayHasKey('delegators', $this->config['dependencies']);
        $this->assertIsArray($this->config['dependencies']['delegators']);
        $this->assertArrayHasKey(Application::class, $this->config['dependencies']['delegators']);
        $this->assertIsArray($this->config['dependencies']['delegators'][Application::class]);
        $this->assertContainsEquals(
            AdminDelegator::class,
            $this->config['dependencies']['delegators'][Application::class]
        );
        $this->assertContainsEquals(
            AppDelegator::class,
            $this->config['dependencies']['delegators'][Application::class]
        );
    }

    public function testDependenciesHasFactories(): void
    {
        $this->assertArrayHasKey('factories', $this->config['dependencies']);
        $this->assertIsArray($this->config['dependencies']['factories']);
        $this->assertArrayHasKey(EntityListenerResolver::class, $this->config['dependencies']['factories']);
        $this->assertArrayHasKey(DashboardController::class, $this->config['dependencies']['factories']);
        $this->assertArrayHasKey(PluginManager::class, $this->config['dependencies']['factories']);
        $this->assertArrayHasKey(FormsPlugin::class, $this->config['dependencies']['factories']);
    }

    public function testDependenciesHasAliases(): void
    {
        $this->assertArrayHasKey('aliases', $this->config['dependencies']);
        $this->assertIsArray($this->config['dependencies']['aliases']);
        $this->assertArrayHasKey(EntityManager::class, $this->config['dependencies']['aliases']);
        $this->assertArrayHasKey(EntityManagerInterface::class, $this->config['dependencies']['aliases']);
    }

    public function testGetTemplates(): void
    {
        $this->assertArrayHasKey('paths', $this->config['templates']);
        $this->assertIsArray($this->config['templates']['paths']);
        $this->assertArrayHasKey('app', $this->config['templates']['paths']);
        $this->assertArrayHasKey('error', $this->config['templates']['paths']);
        $this->assertArrayHasKey('layout', $this->config['templates']['paths']);
        $this->assertArrayHasKey('partial', $this->config['templates']['paths']);
        $this->assertArrayHasKey('language', $this->config['templates']['paths']);
    }
}
