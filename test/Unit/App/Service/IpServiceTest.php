<?php

declare(strict_types=1);

namespace AdminTest\Unit\App\Service;

use Admin\App\Service\IpService;
use AdminTest\Unit\UnitTest;

use function putenv;
use function sprintf;

class IpServiceTest extends UnitTest
{
    private string $ipAddress = '8.8.8.8';

    public function testWillCreate(): void
    {
        $this->assertInstanceOf(IpService::class, new IpService());
    }

    public function testWillGetUserIpFromServerParams(): void
    {
        $this->assertSame($this->ipAddress, IpService::getUserIp([
            'HTTP_X_FORWARDED_FOR' => $this->ipAddress,
        ]));

        $this->assertSame($this->ipAddress, IpService::getUserIp([
            'HTTP_CLIENT_IP' => $this->ipAddress,
        ]));

        $this->assertSame($this->ipAddress, IpService::getUserIp([
            'REMOTE_ADDR' => $this->ipAddress,
        ]));
    }

    public function testWillGetUserIpFromEnv(): void
    {
        putenv(sprintf('HTTP_X_FORWARDED_FOR=%s', $this->ipAddress));
        $this->assertSame($this->ipAddress, IpService::getUserIp([]));
        putenv('HTTP_X_FORWARDED_FOR');

        putenv(sprintf('HTTP_CLIENT_IP=%s', $this->ipAddress));
        $this->assertSame($this->ipAddress, IpService::getUserIp([]));
        putenv('HTTP_CLIENT_IP');

        putenv(sprintf('REMOTE_ADDR=%s', $this->ipAddress));
        $this->assertSame($this->ipAddress, IpService::getUserIp([]));
        putenv('REMOTE_ADDR');
    }

    public function testWillDetectPublicIp(): void
    {
        $this->assertFalse(IpService::isPublicIp("127.0.0.1"));
        $this->assertFalse(IpService::isPublicIp("10.0.0.0"));
        $this->assertFalse(IpService::isPublicIp("::1"));
        $this->assertFalse(IpService::isPublicIp("fd12:3456:789a:1::1"));

        $this->assertTrue(IpService::isPublicIp("8.8.8.8")); // google
        $this->assertTrue(IpService::isPublicIp("2607:f8b0:4003:c00::6a")); //google
    }
}
