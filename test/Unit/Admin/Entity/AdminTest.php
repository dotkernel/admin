<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Entity;

use Admin\Admin\Entity\Admin;
use Admin\Admin\Entity\AdminRole;
use Admin\Admin\Enum\AdminRoleEnum;
use Admin\Admin\Enum\AdminStatusEnum;
use Admin\Admin\Repository\AdminRepository;
use AdminTest\Unit\UnitTest;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Ramsey\Uuid\UuidInterface;
use ReflectionAttribute;
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
        $this->assertInstanceOf(ReflectionAttribute::class, $entity[0]);
        $this->assertInstanceOf(ReflectionAttribute::class, $table[0]);

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
        $this->assertInstanceOf(Admin::class, $admin);

        $this->assertInstanceOf(UuidInterface::class, $admin->getUuid());

        $admin = $admin->setIdentity($this->default['identity']);
        $this->assertInstanceOf(Admin::class, $admin);
        $this->assertSame($this->default['identity'], $admin->getIdentity());

        $this->assertNull($admin->getFirstName());
        $admin = $admin->setFirstName($this->default['firstName']);
        $this->assertInstanceOf(Admin::class, $admin);
        $this->assertSame($this->default['firstName'], $admin->getFirstName());

        $this->assertNull($admin->getLastName());
        $admin = $admin->setLastName($this->default['lastName']);
        $this->assertInstanceOf(Admin::class, $admin);
        $this->assertSame($this->default['lastName'], $admin->getLastName());

        $admin = $admin->setPassword($this->default['password']);
        $this->assertInstanceOf(Admin::class, $admin);
        $this->assertSame($this->default['password'], $admin->getPassword());

        $this->assertSame(AdminStatusEnum::Active, $admin->getStatus());
        $admin = $admin->setStatus($this->default['status']);
        $this->assertInstanceOf(Admin::class, $admin);
        $this->assertSame($this->default['status'], $admin->getStatus());

        $this->assertIsArray($admin->getRoles());
        $this->assertEmpty($admin->getRoles());
        $admin = $admin->addRole($this->default['roles'][0]);
        $this->assertInstanceOf(Admin::class, $admin);
        $this->assertIsArray($admin->getRoles());
        $this->assertCount(1, $admin->getRoles());
        $admin = $admin->removeRole($admin->getRoles()[0]);
        $this->assertInstanceOf(Admin::class, $admin);
        $this->assertIsArray($admin->getRoles());
        $this->assertEmpty($admin->getRoles());
        $roles = new ArrayCollection();
        $roles->add($this->default['roles'][0]);
        $admin = $admin->setRoles($roles);
        $this->assertInstanceOf(Admin::class, $admin);
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
