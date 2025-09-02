<?php

declare(strict_types=1);

namespace Admin\Setting;

use Admin\Setting\Handler\GetViewSettingHandler;
use Admin\Setting\Handler\PostStoreSettingHandler;
use Admin\Setting\Service\SettingService;
use Admin\Setting\Service\SettingServiceInterface;
use Dot\DependencyInjection\Factory\AttributedServiceFactory;
use Mezzio\Application;

/**
 * @phpstan-type ConfigType array{
 *      dependencies: DependenciesType,
 * }
 * @phpstan-type DependenciesType array{
 *      delegators: non-empty-array<class-string, array<class-string>>,
 *      factories: non-empty-array<class-string, class-string>,
 *      aliases: non-empty-array<class-string, class-string>,
 * }
 */
class ConfigProvider
{
    /**
     * @return ConfigType
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * @return DependenciesType
     */
    public function getDependencies(): array
    {
        return [
            'delegators' => [
                Application::class => [RoutesDelegator::class],
            ],
            'factories'  => [
                PostStoreSettingHandler::class => AttributedServiceFactory::class,
                GetViewSettingHandler::class   => AttributedServiceFactory::class,
                SettingService::class          => AttributedServiceFactory::class,
            ],
            'aliases'    => [
                SettingServiceInterface::class => SettingService::class,
            ],
        ];
    }
}
