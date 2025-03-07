<?php

declare(strict_types=1);

namespace Admin\Fixtures;

use Admin\Admin\Entity\Admin;
use Admin\Admin\Entity\AdminRole;
use Admin\Admin\Enum\AdminRoleEnum;
use Admin\Admin\Repository\AdminRoleRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

use function password_hash;

use const PASSWORD_DEFAULT;

class AdminLoader implements FixtureInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var AdminRoleRepository $repository */
        $repository = $manager->getRepository(AdminRole::class);

        $admin = (new Admin())
            ->setIdentity('admin')
            ->setPassword(password_hash('dotadmin', PASSWORD_DEFAULT))
            ->setFirstName('Dotkernel')
            ->setLastName('Admin')
            ->addRole($repository->findByName(AdminRoleEnum::Superuser->value));

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
