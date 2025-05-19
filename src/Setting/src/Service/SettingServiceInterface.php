<?php

declare(strict_types=1);

namespace Admin\Setting\Service;

use Core\Admin\Entity\Admin;
use Core\Setting\Entity\Setting;
use Core\Setting\Enum\SettingIdentifierEnum;

interface SettingServiceInterface
{
    /**
     * @param non-empty-array<non-empty-string, mixed> $filters
     */
    public function findOneBy(array $filters): ?Setting;

    /**
     * @param non-empty-array<non-empty-string, mixed> $data
     */
    public function createSetting(Admin $admin, SettingIdentifierEnum $identifier, array $data): Setting;

    /**
     * @param non-empty-array<non-empty-string, mixed> $data
     */
    public function updateSetting(Setting $setting, array $data): Setting;
}
