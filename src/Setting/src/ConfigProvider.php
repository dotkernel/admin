<?php

declare(strict_types=1);

namespace Admin\Setting;

use Admin\Setting\Handler\GetSettingViewHandler;
use Admin\Setting\Handler\PostSettingStoreHandler;
use Admin\Setting\Service\SettingService;
use Admin\Setting\Service\SettingServiceInterface;
use Dot\DependencyInjection\Factory\AttributedServiceFactory;
use Mezzio\Application;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'delegators' => [
                Application::class => [RoutesDelegator::class],
            ],
            'factories'  => [
                PostSettingStoreHandler::class => AttributedServiceFactory::class,
                GetSettingViewHandler::class   => AttributedServiceFactory::class,
                SettingService::class          => AttributedServiceFactory::class,
            ],
            'aliases'    => [
                SettingServiceInterface::class => SettingService::class,
            ],
        ];
    }
}
