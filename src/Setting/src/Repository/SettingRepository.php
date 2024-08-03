<?php

declare(strict_types=1);

namespace Admin\Setting\Repository;

use Admin\App\Repository\AbstractRepository;
use Admin\Setting\Entity\Setting;
use Dot\DependencyInjection\Attribute\Entity;

#[Entity(Setting::class)]
class SettingRepository extends AbstractRepository
{
    public function save(Setting $setting): Setting
    {
        $this->getEntityManager()->persist($setting);
        $this->getEntityManager()->flush();

        return $setting;
    }
}
