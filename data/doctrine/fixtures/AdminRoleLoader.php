<?php

namespace Admin\Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Frontend\Admin\Entity\AdminRole;

/**
 * Class AdminRoleLoader
 * @package Admin\Fixtures
 */
class AdminRoleLoader implements FixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $superAdminRole = (new AdminRole())->setName(AdminRole::ROLE_SUPERUSER);
        $adminRole = (new AdminRole())->setName(AdminRole::ROLE_ADMIN);

        $manager->persist($superAdminRole);
        $manager->persist($adminRole);

        $manager->flush();
    }
}
