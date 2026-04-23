<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Entity;

use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\AdminLogin;
use Core\Admin\Repository\AdminLoginRepository;
use Core\App\Enum\SuccessFailureEnum;
use Core\App\Enum\YesNoEnum;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Ramsey\Uuid\UuidInterface;
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

        $this->assertContainsOnlyInstancesOf(UuidInterface::class, [$adminLogin->getId()]);

        $this->assertNull($adminLogin->getAdminIp());
        $adminLogin = $adminLogin->setAdminIp('0.0.0.0');
        $this->assertSame(AdminLogin::class, $adminLogin::class);
        $this->assertSame('0.0.0.0', $adminLogin->getAdminIp());

        $this->assertNull($adminLogin->getCountry());
        $adminLogin = $adminLogin->setCountry('test');
        $this->assertSame(AdminLogin::class, $adminLogin::class);
        $this->assertSame('test', $adminLogin->getCountry());

        $this->assertNull($adminLogin->getContinent());
        $adminLogin = $adminLogin->setContinent('test');
        $this->assertSame(AdminLogin::class, $adminLogin::class);
        $this->assertSame('test', $adminLogin->getContinent());

        $this->assertNull($adminLogin->getOrganization());
        $adminLogin = $adminLogin->setOrganization('test');
        $this->assertSame(AdminLogin::class, $adminLogin::class);
        $this->assertSame('test', $adminLogin->getOrganization());

        $this->assertNull($adminLogin->getDeviceType());
        $adminLogin = $adminLogin->setDeviceType('test');
        $this->assertSame(AdminLogin::class, $adminLogin::class);
        $this->assertSame('test', $adminLogin->getDeviceType());

        $this->assertSame(YesNoEnum::No, $adminLogin->getIsMobile());
        $adminLogin = $adminLogin->setIsMobile(YesNoEnum::Yes);
        $this->assertSame(AdminLogin::class, $adminLogin::class);
        $this->assertNotNull($adminLogin->getIsMobile());
        $this->assertSame('yes', $adminLogin->getIsMobile()->value);

        $this->assertNull($adminLogin->getOsName());
        $adminLogin = $adminLogin->setOsName('test');
        $this->assertSame(AdminLogin::class, $adminLogin::class);
        $this->assertSame('test', $adminLogin->getOsName());

        $this->assertNull($adminLogin->getOsVersion());
        $adminLogin = $adminLogin->setOsVersion('test');
        $this->assertSame(AdminLogin::class, $adminLogin::class);
        $this->assertSame('test', $adminLogin->getOsVersion());

        $this->assertNull($adminLogin->getClientType());
        $adminLogin = $adminLogin->setClientType('test');
        $this->assertSame(AdminLogin::class, $adminLogin::class);
        $this->assertSame('test', $adminLogin->getClientType());

        $this->assertNull($adminLogin->getClientName());
        $adminLogin = $adminLogin->setClientName('test');
        $this->assertSame(AdminLogin::class, $adminLogin::class);
        $this->assertSame('test', $adminLogin->getClientName());

        $this->assertSame(YesNoEnum::No, $adminLogin->getIsCrawler());
        $adminLogin = $adminLogin->setIsCrawler(YesNoEnum::Yes);
        $this->assertSame(AdminLogin::class, $adminLogin::class);
        $this->assertNotNull($adminLogin->getIsCrawler());
        $this->assertSame('yes', $adminLogin->getIsCrawler()->value);

        $this->assertSame(SuccessFailureEnum::Fail, $adminLogin->getLoginStatus());
        $adminLogin = $adminLogin->setLoginStatus(SuccessFailureEnum::Success);
        $this->assertSame(AdminLogin::class, $adminLogin::class);
        $this->assertNotNull($adminLogin->getLoginStatus());
        $this->assertSame('success', $adminLogin->getLoginStatus()->value);

        $this->assertNull($adminLogin->getIdentity());
        $adminLogin = $adminLogin->setIdentity('test');
        $this->assertSame(AdminLogin::class, $adminLogin::class);
        $this->assertSame('test', $adminLogin->getIdentity());
    }
}
