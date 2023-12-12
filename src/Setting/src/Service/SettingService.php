<?php

declare(strict_types=1);

namespace Frontend\Setting\Service;

use Dot\AnnotatedServices\Annotation\Inject;
use Frontend\Admin\Entity\Admin;
use Frontend\Setting\Entity\Setting;
use Frontend\Setting\Repository\SettingRepository;

class SettingService
{
    /**
     * @Inject({SettingRepository::class})
     */
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
