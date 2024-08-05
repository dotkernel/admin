<?php

declare(strict_types=1);

namespace Admin\Setting\Service;

use Admin\Admin\Entity\Admin;
use Admin\Setting\Entity\Setting;
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

    public function findOneBy(array $filters): ?object
    {
        return $this->settingRepository->findOneBy($filters);
    }

    public function createSetting(Admin $admin, string $identifier, array $data): Setting
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
