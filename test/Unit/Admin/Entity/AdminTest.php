<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Entity;

use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\Admin;
use Core\Admin\Entity\AdminRole;
use Core\Admin\Enum\AdminRoleEnum;
use Core\Admin\Enum\AdminStatusEnum;
use Core\Admin\Repository\AdminRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Ramsey\Uuid\UuidInterface;
use ReflectionClass;

class AdminTest extends UnitTest
{
    private array $default;

    protected function setUp(): void
    {
        parent::setUp();

        $this->default = [
            'identity'  => 'test@example.com',
            'firstName' => 'firstName',
            'lastName'  => 'lastName',
            'password'  => 'password',
            'status'    => AdminStatusEnum::Active,
            'roles'     => [
                (new AdminRole())->setName(AdminRoleEnum::Admin),
            ],
        ];
    }

    public function testAttributes(): void
    {
        $reflection = new ReflectionClass(Admin::class);
        $entity     = $reflection->getAttributes(Entity::class);
        $table      = $reflection->getAttributes(Table::class);

        $this->assertNotEmpty($entity[0]);
        $this->assertNotEmpty($table[0]);

        $entityArguments = $entity[0]->getArguments();
        $tableArguments  = $table[0]->getArguments();

        $this->assertIsArray($entityArguments);
        $this->assertIsArray($tableArguments);
        $this->assertArrayHasKey('repositoryClass', $entityArguments);
        $this->assertArrayHasKey('name', $tableArguments);
        $this->assertSame(AdminRepository::class, $entityArguments['repositoryClass']);
        $this->assertSame('admin', $tableArguments['name']);
    }

    public function testAccessors(): void
    {
        $admin = new Admin();

        $this->assertContainsOnlyInstancesOf(UuidInterface::class, [$admin->getUuid()]);

        $admin = $admin->setIdentity($this->default['identity']);
        $this->assertSame(Admin::class, $admin::class);
        $this->assertSame($this->default['identity'], $admin->getIdentity());

        $this->assertNull($admin->getFirstName());
        $admin = $admin->setFirstName($this->default['firstName']);
        $this->assertSame(Admin::class, $admin::class);
        $this->assertSame($this->default['firstName'], $admin->getFirstName());

        $this->assertNull($admin->getLastName());
        $admin = $admin->setLastName($this->default['lastName']);
        $this->assertSame(Admin::class, $admin::class);
        $this->assertSame($this->default['lastName'], $admin->getLastName());

        $admin = $admin->setPassword($this->default['password']);
        $this->assertSame(Admin::class, $admin::class);
        $this->assertSame($this->default['password'], $admin->getPassword());

        $this->assertSame(AdminStatusEnum::Active, $admin->getStatus());
        $admin = $admin->setStatus($this->default['status']);
        $this->assertSame(Admin::class, $admin::class);
        $this->assertSame($this->default['status'], $admin->getStatus());

        $this->assertIsArray($admin->getRoles());
        $this->assertEmpty($admin->getRoles());
        $admin = $admin->addRole($this->default['roles'][0]);
        $this->assertSame(Admin::class, $admin::class);
        $this->assertIsArray($admin->getRoles());
        $this->assertCount(1, $admin->getRoles());
        $admin = $admin->removeRole($admin->getRoles()[0]);
        $this->assertSame(Admin::class, $admin::class);
        $this->assertIsArray($admin->getRoles());
        $this->assertEmpty($admin->getRoles());
        $admin = $admin->setRoles($this->default['roles']);
        $this->assertSame(Admin::class, $admin::class);
        $this->assertIsArray($admin->getRoles());
        $this->assertCount(1, $admin->getRoles());
    }

    public function testWillGetArrayCopy(): void
    {
        $admin = (new Admin())
            ->setIdentity($this->default['identity'])
            ->setFirstName($this->default['firstName'])
            ->setLastName($this->default['lastName'])
            ->setPassword($this->default['password'])
            ->setStatus($this->default['status'])
            ->addRole(
                $this->default['roles'][0]
            );

        $copy = $admin->getArrayCopy();
        $this->assertIsArray($copy);

        $this->assertArrayHasKey('uuid', $copy);
        $this->assertIsString($copy['uuid']);
        $this->assertNotEmpty($copy['uuid']);

        $this->assertArrayHasKey('identity', $copy);
        $this->assertSame($this->default['identity'], $copy['identity']);

        $this->assertArrayHasKey('firstName', $copy);
        $this->assertSame($this->default['firstName'], $copy['firstName']);

        $this->assertArrayHasKey('lastName', $copy);
        $this->assertSame($this->default['lastName'], $copy['lastName']);

        $this->assertArrayHasKey('status', $copy);
        $this->assertSame($this->default['status']->value, $copy['status']);

        $this->assertArrayHasKey('roles', $copy);
        $this->assertIsArray($copy['roles']);
        $this->assertCount(1, $copy['roles']);
        $this->assertSame($this->default['roles'][0]->getName()->value, $copy['roles'][0]['name']);

        $this->assertArrayHasKey('created', $copy);

        $this->assertArrayHasKey('updated', $copy);
    }
}
