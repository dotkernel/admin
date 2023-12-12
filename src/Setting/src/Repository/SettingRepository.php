<?php

declare(strict_types=1);

namespace Frontend\Setting\Repository;

use Dot\AnnotatedServices\Annotation\Entity;
use Frontend\App\Repository\AbstractRepository;
use Frontend\Setting\Entity\Setting;

/**
 * @Entity(name="Frontend\Setting\Entity\Setting")
 */
class SettingRepository extends AbstractRepository
{
    public function save(Setting $setting): Setting
    {
        $this->getEntityManager()->persist($setting);
        $this->getEntityManager()->flush();

        return $setting;
    }
}
