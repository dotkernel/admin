<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Entity;

use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\AdminIdentity;
use Core\Admin\Entity\AdminRole;
use Core\Admin\Enum\AdminRoleEnum;
use Core\Admin\Enum\AdminStatusEnum;

class AdminIdentityTest extends UnitTest
{
    /** @var array<non-empty-string, mixed> $default */
    private array $default;

    protected function setUp(): void
    {
        parent::setUp();

        $this->default = [
            'uuid'     => '00000000-0000-0000-0000-000000000000',
            'identity' => 'test@example.com',
            'status'   => AdminStatusEnum::Inactive,
            'roles'    => [
                (new AdminRole())->setName(AdminRoleEnum::Admin),
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
        $this->assertSame($this->default['uuid'], $adminIdentity->getUuid());
        $this->assertSame($this->default['identity'], $adminIdentity->getIdentity());
        $this->assertSame($this->default['status'], $adminIdentity->getStatus());
        $this->assertSame($this->default['roles'], $adminIdentity->getRoles());
        $this->assertSame($this->default['details'], $adminIdentity->getDetails());
        $this->assertSame($this->default['details']['firstName'], $adminIdentity->getDetail('firstName'));
        $this->assertSame('default', $adminIdentity->getDetail('test', 'default'));
    }
}
