<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Entity;

use Admin\Admin\Entity\AdminLogin;
use Admin\Admin\Repository\AdminLoginRepository;
use AdminTest\Unit\UnitTest;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Ramsey\Uuid\UuidInterface;
use ReflectionAttribute;
use ReflectionClass;

class AdminLoginTest extends UnitTest
{
    public function testAttributes(): void
    {
        $reflection = new ReflectionClass(AdminLogin::class);
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
        $this->assertSame(AdminLoginRepository::class, $entityArguments['repositoryClass']);
        $this->assertSame('admin_login', $tableArguments['name']);
    }

    public function testAccessors(): void
    {
        $adminLogin = new AdminLogin();
        $this->assertInstanceOf(AdminLogin::class, $adminLogin);

        $this->assertInstanceOf(UuidInterface::class, $adminLogin->getUuid());

        $this->assertNull($adminLogin->getAdminIp());
        $adminLogin = $adminLogin->setAdminIp('0.0.0.0');
        $this->assertInstanceOf(AdminLogin::class, $adminLogin);
        $this->assertSame('0.0.0.0', $adminLogin->getAdminIp());

        $this->assertNull($adminLogin->getCountry());
        $adminLogin = $adminLogin->setCountry('test');
        $this->assertInstanceOf(AdminLogin::class, $adminLogin);
        $this->assertSame('test', $adminLogin->getCountry());

        $this->assertNull($adminLogin->getContinent());
        $adminLogin = $adminLogin->setContinent('test');
        $this->assertInstanceOf(AdminLogin::class, $adminLogin);
        $this->assertSame('test', $adminLogin->getContinent());

        $this->assertNull($adminLogin->getOrganization());
        $adminLogin = $adminLogin->setOrganization('test');
        $this->assertInstanceOf(AdminLogin::class, $adminLogin);
        $this->assertSame('test', $adminLogin->getOrganization());

        $this->assertNull($adminLogin->getDeviceType());
        $adminLogin = $adminLogin->setDeviceType('test');
        $this->assertInstanceOf(AdminLogin::class, $adminLogin);
        $this->assertSame('test', $adminLogin->getDeviceType());

        $this->assertNull($adminLogin->getDeviceBrand());
        $adminLogin = $adminLogin->setDeviceBrand('test');
        $this->assertInstanceOf(AdminLogin::class, $adminLogin);
        $this->assertSame('test', $adminLogin->getDeviceBrand());

        $this->assertNull($adminLogin->getDeviceModel());
        $adminLogin = $adminLogin->setDeviceModel('test');
        $this->assertInstanceOf(AdminLogin::class, $adminLogin);
        $this->assertSame('test', $adminLogin->getDeviceModel());

        $this->assertNull($adminLogin->getIsMobile());
        $adminLogin = $adminLogin->setIsMobile('yes');
        $this->assertInstanceOf(AdminLogin::class, $adminLogin);
        $this->assertSame('yes', $adminLogin->getIsMobile());

        $this->assertNull($adminLogin->getOsName());
        $adminLogin = $adminLogin->setOsName('test');
        $this->assertInstanceOf(AdminLogin::class, $adminLogin);
        $this->assertSame('test', $adminLogin->getOsName());

        $this->assertNull($adminLogin->getOsVersion());
        $adminLogin = $adminLogin->setOsVersion('test');
        $this->assertInstanceOf(AdminLogin::class, $adminLogin);
        $this->assertSame('test', $adminLogin->getOsVersion());

        $this->assertNull($adminLogin->getOsPlatform());
        $adminLogin = $adminLogin->setOsPlatform('test');
        $this->assertInstanceOf(AdminLogin::class, $adminLogin);
        $this->assertSame('test', $adminLogin->getOsPlatform());

        $this->assertNull($adminLogin->getClientType());
        $adminLogin = $adminLogin->setClientType('test');
        $this->assertInstanceOf(AdminLogin::class, $adminLogin);
        $this->assertSame('test', $adminLogin->getClientType());

        $this->assertNull($adminLogin->getClientName());
        $adminLogin = $adminLogin->setClientName('test');
        $this->assertInstanceOf(AdminLogin::class, $adminLogin);
        $this->assertSame('test', $adminLogin->getClientName());

        $this->assertNull($adminLogin->getClientEngine());
        $adminLogin = $adminLogin->setClientEngine('test');
        $this->assertInstanceOf(AdminLogin::class, $adminLogin);
        $this->assertSame('test', $adminLogin->getClientEngine());

        $this->assertNull($adminLogin->getClientVersion());
        $adminLogin = $adminLogin->setClientVersion('test');
        $this->assertInstanceOf(AdminLogin::class, $adminLogin);
        $this->assertSame('test', $adminLogin->getClientVersion());

        $this->assertNull($adminLogin->getLoginStatus());
        $adminLogin = $adminLogin->setLoginStatus('success');
        $this->assertInstanceOf(AdminLogin::class, $adminLogin);
        $this->assertSame('success', $adminLogin->getLoginStatus());

        $this->assertNull($adminLogin->getIdentity());
        $adminLogin = $adminLogin->setIdentity('test');
        $this->assertInstanceOf(AdminLogin::class, $adminLogin);
        $this->assertSame('test', $adminLogin->getIdentity());
    }
}
