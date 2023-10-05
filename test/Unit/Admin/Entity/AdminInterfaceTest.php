<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Frontend\Admin\Entity\AdminInterface;
use Frontend\Admin\Entity\AdminRole;
use FrontendTest\Unit\UnitTest;

class AdminInterfaceTest extends UnitTest
{
    public function testWillInstantiate(): void
    {
        $instance = new class implements AdminInterface {
            public function getArrayCopy(): array
            {
                return [];
            }

            public function getIdentity(): ?string
            {
                return 'test';
            }

            public function setIdentity(string $identity): AdminInterface
            {
                return $this;
            }

            public function getFirstName(): ?string
            {
                return 'test';
            }

            public function setFirstName(string $firstName): AdminInterface
            {
                return $this;
            }

            public function getLastName(): ?string
            {
                return 'test';
            }

            public function setLastName(string $lastName): AdminInterface
            {
                return $this;
            }

            public function getPassword(): ?string
            {
                return 'test';
            }

            public function setPassword(string $password): AdminInterface
            {
                return $this;
            }

            public function getStatus(): string
            {
                return 'test';
            }

            public function setStatus(string $status): AdminInterface
            {
                return $this;
            }

            public function getRoles(): array
            {
                return [];
            }

            public function setRoles(ArrayCollection $roles): AdminInterface
            {
                return $this;
            }

            public function addRole(AdminRole $role): AdminInterface
            {
                return $this;
            }

            public function removeRole(AdminRole $role): AdminInterface
            {
                return $this;
            }
        };
        $this->assertInstanceOf(AdminInterface::class, $instance);
    }
}
