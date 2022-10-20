<?php

namespace Admin\Fixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Frontend\Admin\Entity\Admin;
use Frontend\Admin\Entity\AdminRole;

/**
 * Class AdminLoader
 * @package Admin\Fixtures
 */
class AdminLoader implements FixtureInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $admin = new Admin();

        $admin->setIdentity('admin');
        $admin->setPassword(password_hash('dotadmin', PASSWORD_DEFAULT));
        $admin->setFirstName('DotKernel');
        $admin->setLastName('Admin');

        /** @var AdminRole $superUserRole */
        $adminRoleRepository = $manager->getRepository(AdminRole::class);
        $superUserRole = $adminRoleRepository->findOneBy(['name' => AdminRole::ROLE_SUPERUSER]);

        $admin->addRole($superUserRole);

        $manager->persist($admin);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AdminRoleLoader::class
        ];
    }
}
