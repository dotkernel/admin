<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\Entity;

use DateTimeInterface;
use Frontend\Admin\Entity\AdminRole;
use FrontendTest\Unit\UnitTest;
use Ramsey\Uuid\Rfc4122\UuidInterface;
use ReflectionClass;

class AdminRoleTest extends UnitTest
{
    public function testAnnotations(): void
    {
        $reflection = new ReflectionClass(AdminRole::class);
        $docComment = $reflection->getDocComment();
        $this->assertStringContainsString(
            '@ORM\Entity(repositoryClass="Frontend\Admin\Repository\AdminRoleRepository")',
            $docComment
        );
        $this->assertStringContainsString('@ORM\Table(name="admin_role")', $docComment);
        $this->assertStringContainsString('@ORM\HasLifecycleCallbacks()', $docComment);
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
