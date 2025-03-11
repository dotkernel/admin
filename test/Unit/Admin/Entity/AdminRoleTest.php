<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Entity;

use Admin\Admin\Entity\AdminRole;
use Admin\Admin\Enum\AdminRoleEnum;
use Admin\Admin\Repository\AdminRoleRepository;
use AdminTest\Unit\UnitTest;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Ramsey\Uuid\UuidInterface;
use ReflectionAttribute;
use ReflectionClass;

class AdminRoleTest extends UnitTest
{
    public function testAttributes(): void
    {
        $reflection = new ReflectionClass(AdminRole::class);
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
        $this->assertSame(AdminRoleRepository::class, $entityArguments['repositoryClass']);
        $this->assertSame('admin_role', $tableArguments['name']);
    }

    public function testAccessors(): void
    {
        $adminRole = new AdminRole();
        $this->assertInstanceOf(AdminRole::class, $adminRole);

        $this->assertInstanceOf(UuidInterface::class, $adminRole->getUuid());

        $this->assertSame(AdminRoleEnum::Admin, $adminRole->getName());
        $adminRole = $adminRole->setName(AdminRoleEnum::Admin);
        $this->assertInstanceOf(AdminRole::class, $adminRole);
        $this->assertSame(AdminRoleEnum::Admin, $adminRole->getName());
    }

    public function testWillGetArrayCopy(): void
    {
        $adminRole = (new AdminRole())->setName(AdminRoleEnum::Admin);

        $copy = $adminRole->getArrayCopy();
        $this->assertIsArray($copy);

        $this->assertArrayHasKey('uuid', $copy);
        $this->assertIsString($copy['uuid']);
        $this->assertNotEmpty($copy['uuid']);

        $this->assertArrayHasKey('name', $copy);
        $this->assertSame(AdminRoleEnum::Admin->value, $copy['name']);

        $this->assertArrayHasKey('created', $copy);

        $this->assertArrayHasKey('updated', $copy);
    }
}
