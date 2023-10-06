<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\FormData;

use Frontend\Admin\Entity\Admin;
use Frontend\Admin\Entity\AdminRole;
use Frontend\Admin\FormData\AdminFormData;
use FrontendTest\Unit\UnitTest;

use function array_map;

class AdminFormDataTest extends UnitTest
{
    public function testWillInstantiate(): void
    {
        $this->assertInstanceOf(AdminFormData::class, new AdminFormData());
    }

    public function testWillPopulateFromEntity(): void
    {
        $admin = $this->getAdmin();

        $formData = new AdminFormData();
        $this->assertInstanceOf(AdminFormData::class, $formData->fromEntity($admin));
        $this->assertSame($admin->getIdentity(), $formData->identity);
        $this->assertSame($admin->getFirstName(), $formData->firstName);
        $this->assertSame($admin->getLastName(), $formData->lastName);
        $this->assertSame($admin->getStatus(), $formData->status);
        $this->assertIsArray($formData->roles);
        $this->assertCount(1, $formData->roles);
        $this->assertSame($admin->getRoles()[0]->getUuid()->toString(), $formData->roles[0]);
    }

    public function testWillGetArrayCopy(): void
    {
        $admin = $this->getAdmin();

        $copy = (new AdminFormData())->fromEntity($admin)->getArrayCopy();
        $this->assertIsArray($copy);
        $this->assertCount(5, $copy);

        $this->assertArrayHasKey('identity', $copy);
        $this->assertSame($admin->getIdentity(), $copy['identity']);

        $this->assertArrayHasKey('firstName', $copy);
        $this->assertSame($admin->getFirstName(), $copy['firstName']);

        $this->assertArrayHasKey('lastName', $copy);
        $this->assertSame($admin->getLastName(), $copy['lastName']);

        $this->assertArrayHasKey('status', $copy);
        $this->assertSame($admin->getStatus(), $copy['status']);

        $this->assertArrayHasKey('roles', $copy);
        $this->assertIsArray($copy['roles']);
        $this->assertSame(array_map(function (AdminRole $role): string {
            return $role->getUuid()->toString();
        }, $admin->getRoles()), $copy['roles']);
    }

    public function testWillGetRoles(): void
    {
        $admin = $this->getAdmin();

        $roles = (new AdminFormData())->fromEntity($admin)->getRoles();

        $this->assertIsArray($roles);
        $this->assertCount(1, $roles);
        $this->assertSame($admin->getRoles()[0]->getUuid()->toString(), $roles[0]);
    }

    private function getAdmin(): Admin
    {
        return (new Admin())
            ->setIdentity('test')
            ->setFirstName('firstname')
            ->setLastName('lastname')
            ->setStatus(Admin::STATUS_ACTIVE)
            ->addRole(
                (new AdminRole())->setName(AdminRole::ROLE_ADMIN)
            );
    }
}
