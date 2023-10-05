<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\Entity;

use DateTimeInterface;
use Frontend\Admin\Entity\AdminLogin;
use FrontendTest\Unit\UnitTest;
use Ramsey\Uuid\Rfc4122\UuidInterface;
use ReflectionClass;

class AdminLoginTest extends UnitTest
{
    public function testAnnotations(): void
    {
        $reflection = new ReflectionClass(AdminLogin::class);
        $docComment = $reflection->getDocComment();
        $this->assertStringContainsString(
            '@ORM\Entity(repositoryClass="Frontend\Admin\Repository\AdminLoginRepository")',
            $docComment
        );
        $this->assertStringContainsString('@ORM\Table(name="admin_login")', $docComment);
        $this->assertStringContainsString('@ORM\HasLifecycleCallbacks()', $docComment);
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

        $this->assertInstanceOf(DateTimeInterface::class, $adminLogin->getCreated());
        $this->assertIsString($adminLogin->getCreatedFormatted());

        $this->assertInstanceOf(DateTimeInterface::class, $adminLogin->getUpdated());
        $this->assertIsString($adminLogin->getUpdatedFormatted());
    }
}
