<?php

declare(strict_types=1);

namespace Admin\Fixtures;

use Admin\Admin\Entity\AdminRole;
use Admin\Admin\Enum\AdminRoleEnum;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AdminRoleLoader implements FixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist(
            (new AdminRole())->setName(AdminRoleEnum::Superuser)
        );
        $manager->persist(
            (new AdminRole())->setName(AdminRoleEnum::Admin)
        );

        $manager->flush();
    }
}
