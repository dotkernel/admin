<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\Entity;

use Frontend\Admin\Entity\Admin;
use Frontend\Admin\Entity\AdminIdentity;
use Frontend\Admin\Entity\AdminRole;
use FrontendTest\Unit\UnitTest;

class AdminIdentityTest extends UnitTest
{
    private array $default;

    protected function setUp(): void
    {
        parent::setUp();

        $this->default = [
            'uuid'     => '00000000-0000-0000-0000-000000000000',
            'identity' => 'test@example.com',
            'status'   => Admin::STATUS_INACTIVE,
            'roles'    => [
                (new AdminRole())->setName(AdminRole::ROLE_ADMIN),
            ],
            'details'  => [
                'firstName' => 'firstName',
                'lastName'  => 'lastName',
                'email'     => 'test@example.com',
            ],
        ];
    }

    public function testAll(): void
    {
        $adminIdentity = new AdminIdentity(
            $this->default['uuid'],
            $this->default['identity'],
            $this->default['status'],
            $this->default['roles'],
            $this->default['details'],
        );
        $this->assertInstanceOf(AdminIdentity::class, $adminIdentity);
        $this->assertSame($this->default['uuid'], $adminIdentity->getUuid());
        $this->assertSame($this->default['identity'], $adminIdentity->getIdentity());
        $this->assertSame($this->default['status'], $adminIdentity->getStatus());
        $this->assertSame($this->default['roles'], $adminIdentity->getRoles());
        $this->assertSame($this->default['details'], $adminIdentity->getDetails());
        $this->assertSame($this->default['details']['firstName'], $adminIdentity->getDetail('firstName'));
        $this->assertSame('default', $adminIdentity->getDetail('test', 'default'));
    }
}
