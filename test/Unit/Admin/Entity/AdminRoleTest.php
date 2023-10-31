<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Table;
use Frontend\Admin\Entity\AdminRole;
use Frontend\Admin\Repository\AdminRoleRepository;
use FrontendTest\Unit\UnitTest;
use Ramsey\Uuid\Rfc4122\UuidInterface;
use ReflectionAttribute;
use ReflectionClass;

class AdminRoleTest extends UnitTest
{
    public function testAnnotations(): void
    {
        $reflection            = new ReflectionClass(AdminRole::class);
        $entity                = $reflection->getAttributes(Entity::class);
        $table                 = $reflection->getAttributes(Table::class);
        $hasLifecycleCallbacks = $reflection->getAttributes(HasLifecycleCallbacks::class);

        $this->assertNotEmpty($entity[0]);
        $this->assertNotEmpty($table[0]);
        $this->assertNotEmpty($hasLifecycleCallbacks[0]);
        $this->assertInstanceOf(ReflectionAttribute::class, $entity[0]);
        $this->assertInstanceOf(ReflectionAttribute::class, $table[0]);
        $this->assertInstanceOf(ReflectionAttribute::class, $hasLifecycleCallbacks[0]);

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

        $this->assertNull($adminRole->getName());
        $adminRole = $adminRole->setName(AdminRole::ROLE_ADMIN);
        $this->assertInstanceOf(AdminRole::class, $adminRole);
        $this->assertSame(AdminRole::ROLE_ADMIN, $adminRole->getName());

        $this->assertInstanceOf(DateTimeInterface::class, $adminRole->getCreated());
        $this->assertIsString($adminRole->getCreatedFormatted());

        $this->assertInstanceOf(DateTimeInterface::class, $adminRole->getUpdated());
        $this->assertIsString($adminRole->getUpdatedFormatted());
    }

    public function testWillGetArrayCopy(): void
    {
        $adminRole = (new AdminRole())->setName(AdminRole::ROLE_ADMIN);

        $copy = $adminRole->getArrayCopy();
        $this->assertIsArray($copy);

        $this->assertArrayHasKey('uuid', $copy);
        $this->assertIsString($copy['uuid']);
        $this->assertNotEmpty($copy['uuid']);

        $this->assertArrayHasKey('name', $copy);
        $this->assertSame(AdminRole::ROLE_ADMIN, $copy['name']);

        $this->assertArrayHasKey('created', $copy);
        $this->assertInstanceOf(DateTimeInterface::class, $copy['created']);

        $this->assertArrayHasKey('updated', $copy);
        $this->assertInstanceOf(DateTimeInterface::class, $copy['updated']);
    }
}
