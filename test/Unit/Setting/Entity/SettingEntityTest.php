<?php

declare(strict_types=1);

namespace AdminTest\Unit\Setting\Entity;

use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\Admin;
use Core\Setting\Entity\Setting;
use Core\Setting\Enum\SettingIdentifierEnum;
use Core\Setting\Repository\SettingRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use PHPUnit\Framework\MockObject\Exception;
use ReflectionClass;

class SettingEntityTest extends UnitTest
{
    private Admin $admin;
    private SettingIdentifierEnum $identifier = SettingIdentifierEnum::IdentifierTableAdminListSelectedColumns;
    /** @var non-empty-string[] $values */
    private array $values = ['foo', 'bar', 'baz'];

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->admin = $this->createStub(Admin::class);
    }

    public function testAttributes(): void
    {
        $reflection = new ReflectionClass(Setting::class);
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
        $this->assertSame(SettingRepository::class, $entityArguments['repositoryClass']);
        $this->assertSame('settings', $tableArguments['name']);
    }

    public function testAccessors(): void
    {
        $setting = new Setting($this->admin, $this->identifier, $this->values);

        $this->assertSame($this->admin, $setting->getAdmin());
        $this->assertSame($this->identifier, $setting->getIdentifier());
        $this->assertSame($this->values, $setting->getValue());

        //test individual accessors also
        $this->assertSame($this->admin, $setting->setAdmin($this->admin)->getAdmin());
        $this->assertSame($this->identifier, $setting->setIdentifier($this->identifier)->getIdentifier());
        $this->assertSame($this->values, $setting->setValue($this->values)->getValue());
    }

    public function testWillGetArrayCopy(): void
    {
        $setting = new Setting($this->admin, $this->identifier, $this->values);

        $copy = $setting->getArrayCopy();

        $this->assertArrayHasKey('identifier', $copy);
        $this->assertSame($this->identifier->value, $copy['identifier']);

        $this->assertArrayHasKey('value', $copy);
        $this->assertSame($this->values, $copy['value']);
    }
}
