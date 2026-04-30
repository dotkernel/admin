<?php

declare(strict_types=1);

namespace AdminTest\Unit\App\Service;

use AdminTest\Unit\UnitTest;
use Core\App\Service\IpService;

use function putenv;
use function sprintf;

class IpServiceTest extends UnitTest
{
    private string $ipAddress = '8.8.8.8';

    public function testWillCreate(): void
    {
        $this->assertSame(IpService::class, (new IpService())::class);
    }

    public function testWillGetUserIpFromServerParams(): void
    {
        $this->assertSame($this->ipAddress, IpService::getUserIp([
            'HTTP_X_FORWARDED_FOR' => $this->ipAddress,
            'REMOTE_ADDR'          => '',
        ]));

        $this->assertSame($this->ipAddress, IpService::getUserIp([
            'HTTP_CLIENT_IP' => $this->ipAddress,
            'REMOTE_ADDR'    => '',
        ]));

        $this->assertSame($this->ipAddress, IpService::getUserIp([
            'REMOTE_ADDR' => $this->ipAddress,
        ]));
    }

    public function testWillGetUserIpFromEnv(): void
    {
        /** @var array{HTTP_X_FORWARDED_FOR?: string, HTTP_CLIENT_IP?: string, REMOTE_ADDR: string} $emptyServer */
        $emptyServer = [];

        putenv(sprintf('HTTP_X_FORWARDED_FOR=%s', $this->ipAddress));
        $this->assertSame($this->ipAddress, IpService::getUserIp($emptyServer));
        putenv('HTTP_X_FORWARDED_FOR');

        putenv(sprintf('HTTP_CLIENT_IP=%s', $this->ipAddress));
        $this->assertSame($this->ipAddress, IpService::getUserIp($emptyServer));
        putenv('HTTP_CLIENT_IP');

        putenv(sprintf('REMOTE_ADDR=%s', $this->ipAddress));
        $this->assertSame($this->ipAddress, IpService::getUserIp($emptyServer));
        putenv('REMOTE_ADDR');
    }

    public function testWillDetectPublicIp(): void
    {
        $this->assertFalse(IpService::isPublicIp("127.0.0.1"));
        $this->assertFalse(IpService::isPublicIp("10.0.0.0"));
        $this->assertFalse(IpService::isPublicIp("::1"));
        $this->assertFalse(IpService::isPublicIp("fd12:3456:789a:1::1"));

        $this->assertTrue(IpService::isPublicIp("8.8.8.8"));
        $this->assertTrue(IpService::isPublicIp("2607:f8b0:4003:c00::6a"));
    }
}
