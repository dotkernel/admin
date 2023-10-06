<?php

declare(strict_types=1);

namespace FrontendTest\Unit\App\Service;

use Frontend\App\Service\IpService;
use FrontendTest\Unit\UnitTest;

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

    public function testWillDetectIfValidIp(): void
    {
        $this->assertSame('private', IpService::validIp('127.0.0.1'));

        $this->assertSame('public', IpService::validIp($this->ipAddress));

        $this->assertFalse(IpService::validIp('test'));
    }
}
