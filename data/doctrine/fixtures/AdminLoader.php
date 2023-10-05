<?php

declare(strict_types=1);

namespace Admin\Fixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Frontend\Admin\Entity\Admin;
use Frontend\Admin\Entity\AdminRole;

use function password_hash;

use const PASSWORD_DEFAULT;

class AdminLoader implements FixtureInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $admin = (new Admin())
            ->setIdentity('admin')
            ->setPassword(password_hash('dotadmin', PASSWORD_DEFAULT))
            ->setFirstName('DotKernel')
            ->setLastName('Admin')
            ->addRole(
                $manager->getRepository(AdminRole::class)->findOneBy(['name' => AdminRole::ROLE_SUPERUSER])
            );

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
