<?php

declare(strict_types=1);

namespace Admin\Setting\Service;

use Core\Admin\Entity\Admin;
use Core\Setting\Entity\Setting;
use Core\Setting\Enum\SettingIdentifierEnum;

interface SettingServiceInterface
{
    public function findOneBy(array $filters): ?Setting;

    public function createSetting(Admin $admin, SettingIdentifierEnum $identifier, array $data): Setting;

    public function updateSetting(Setting $setting, array $data): Setting;
}
