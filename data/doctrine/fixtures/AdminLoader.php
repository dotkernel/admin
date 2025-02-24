<?php

declare(strict_types=1);

namespace Admin\Fixtures;

use Admin\Admin\Entity\Admin;
use Admin\Admin\Entity\AdminRole;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

use function assert;
use function password_hash;

use const PASSWORD_DEFAULT;

class AdminLoader implements FixtureInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $role = $manager->getRepository(AdminRole::class)->findOneBy(['name' => AdminRole::ROLE_SUPERUSER]);
        assert($role instanceof AdminRole);

        $admin = (new Admin())
            ->setIdentity('admin')
            ->setPassword(password_hash('dotadmin', PASSWORD_DEFAULT))
            ->setFirstName('DotKernel')
            ->setLastName('Admin')
            ->addRole($role);

        $manager->persist($admin);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AdminRoleLoader::class,
        ];
    }
}
