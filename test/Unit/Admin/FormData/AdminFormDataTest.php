<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\FormData;

use Admin\Admin\Entity\Admin;
use Admin\Admin\Entity\AdminRole;
use Admin\Admin\Enum\AdminRoleEnum;
use Admin\Admin\Enum\AdminStatusEnum;
use Admin\Admin\FormData\AdminFormData;
use AdminTest\Unit\UnitTest;

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
        $this->assertSame($admin->getStatus()->value, $formData->status);
        $this->assertIsArray($formData->roles);
        $this->assertCount(1, $formData->roles);
        $this->assertSame($admin->getRoles()[0]->getUuid()->toString(), $formData->roles[0]['value']);
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
        $this->assertSame($admin->getStatus()->value, $copy['status']);

        $this->assertArrayHasKey('roles', $copy);
        $this->assertIsArray($copy['roles']);
        $this->assertSame(array_map(function (AdminRole $role): array {
            return [
                'label' => $role->getName(),
                'value' => $role->getUuid()->toString(),
            ];
        }, $admin->getRoles()), $copy['roles']);
    }

    public function testWillGetRoles(): void
    {
        $admin = $this->getAdmin();

        $roles = (new AdminFormData())->fromEntity($admin)->getRoles();

        $this->assertIsArray($roles);
        $this->assertCount(1, $roles);
        $this->assertSame($admin->getRoles()[0]->getUuid()->toString(), $roles[0]['value']);
    }

    private function getAdmin(): Admin
    {
        return (new Admin())
            ->setIdentity('test')
            ->setFirstName('firstname')
            ->setLastName('lastname')
            ->setStatus(AdminStatusEnum::Active)
            ->addRole(
                (new AdminRole())->setName(AdminRoleEnum::Admin)
            );
    }
}
