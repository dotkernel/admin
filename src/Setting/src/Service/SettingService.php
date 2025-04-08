<?php

declare(strict_types=1);

namespace Admin\Setting\Service;

use Core\Admin\Entity\Admin;
use Core\Setting\Entity\Setting;
use Core\Setting\Enum\SettingIdentifierEnum;
use Core\Setting\Repository\SettingRepository;
use Dot\DependencyInjection\Attribute\Inject;

class SettingService implements SettingServiceInterface
{
    #[Inject(
        SettingRepository::class,
    )]
    public function __construct(
        private SettingRepository $settingRepository,
    ) {
    }

    public function findOneBy(array $filters): ?Setting
    {
        $setting = $this->settingRepository->findOneBy($filters);
        if ($setting instanceof Setting) {
            return $setting;
        }

        return null;
    }

    public function createSetting(Admin $admin, SettingIdentifierEnum $identifier, array $data): Setting
    {
        $setting = new Setting($admin, $identifier, $data);

        $this->settingRepository->saveResource($setting);

        return $setting;
    }

    public function updateSetting(Setting $setting, array $data): Setting
    {
        $setting->setValue($data);

        $this->settingRepository->saveResource($setting);

        return $setting;
    }
}
