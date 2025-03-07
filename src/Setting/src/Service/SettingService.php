<?php

declare(strict_types=1);

namespace Admin\Setting\Service;

use Admin\Admin\Entity\Admin;
use Admin\Setting\Entity\Setting;
use Admin\Setting\Enum\SettingEnum;
use Admin\Setting\Repository\SettingRepository;
use Dot\DependencyInjection\Attribute\Inject;

class SettingService
{
    #[Inject(
        SettingRepository::class,
    )]
    public function __construct(private SettingRepository $settingRepository)
    {
    }

    public function findOneBy(array $filters): ?Setting
    {
        $setting = $this->settingRepository->findOneBy($filters);
        if ($setting instanceof Setting) {
            return $setting;
        }

        return null;
    }

    public function createSetting(Admin $admin, SettingEnum $identifier, array $data): Setting
    {
        $setting = new Setting($admin, $identifier, $data);

        return $this->settingRepository->save($setting);
    }

    public function updateSetting(Setting $setting, array $data): Setting
    {
        $setting->setValue($data);

        return $this->settingRepository->save($setting);
    }
}
