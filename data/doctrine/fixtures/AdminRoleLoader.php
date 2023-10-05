<?php

declare(strict_types=1);

namespace Admin\Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Frontend\Admin\Entity\AdminRole;

class AdminRoleLoader implements FixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist(
            (new AdminRole())->setName(AdminRole::ROLE_SUPERUSER)
        );
        $manager->persist(
            (new AdminRole())->setName(AdminRole::ROLE_ADMIN)
        );

        $manager->flush();
    }
}
