<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Adapter;

use Admin\Admin\Adapter\AuthenticationAdapter;
use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\Admin;
use Core\Admin\Enum\AdminStatusEnum;
use Core\Admin\Repository\AdminRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Exception;
use PHPUnit\Framework\MockObject\Exception as MockObjectException;
use ReflectionClass;
use ReflectionException;

use function password_hash;
use function sprintf;

use const PASSWORD_DEFAULT;

class AuthenticationAdapterTest extends UnitTest
{
    /**
     * @throws MockObjectException
     * @throws ReflectionException
     */
    public function testAccessors(): void
    {
        $adapter = new AuthenticationAdapter(
            $this->createMock(EntityManager::class),
            []
        );

        $adapter = $adapter->setIdentity('identity');
        $this->assertSame(AuthenticationAdapter::class, $adapter::class);
        $adapter = $adapter->setCredential('credential');
        $this->assertSame(AuthenticationAdapter::class, $adapter::class);

        $reflection = new ReflectionClass($adapter);

        $method = $reflection->getMethod('getIdentity');
        $this->assertSame('identity', $method->invoke($adapter));
        $method = $reflection->getMethod('getCredential');
        $this->assertSame('credential', $method->invoke($adapter));
    }

    /**
     * @throws MockObjectException
     * @throws ORMException
     */
    public function testWillNotAuthenticateWithoutValidConfig(): void
    {
        $adapter = new AuthenticationAdapter(
            $this->createMock(EntityManager::class),
            []
        );
        $this->expectExceptionMessage('No or invalid param "identity_class" provided.');
        $adapter->authenticate();

        $adapter = new AuthenticationAdapter(
            $this->createMock(EntityManager::class),
            [
                'orm_default' => [
                    'identity_class' => Admin::class,
                ],
            ],
        );
        $this->expectExceptionMessage('No or invalid param "identity_class" provided.');
        $adapter->authenticate();

        $adapter = new AuthenticationAdapter(
            $this->createMock(EntityManager::class),
            [
                'orm_default' => [
                    'identity_class'    => Admin::class,
                    'identity_property' => 'identity',
                ],
            ],
        );
        $this->expectExceptionMessage('No or invalid param "credential_property" provided.');
        $adapter->authenticate();

        $adapter = new AuthenticationAdapter(
            $this->createMock(EntityManager::class),
            [
                'orm_default' => [
                    'identity_class'      => Admin::class,
                    'identity_property'   => 'identity',
                    'credential_property' => 'password',
                ],
            ],
        );
        $this->expectExceptionMessage('No credentials provided.');
        $adapter->authenticate();
    }

    /**
     * @throws MockObjectException
     * @throws ORMException
     */
    public function testWillNotAuthenticateWithInvalidIdentityClassConfig(): void
    {
        $adapter = new AuthenticationAdapter(
            $this->createMock(EntityManager::class),
            [
                'orm_default' => [
                    'identity_class'      => Exception::class,
                    'identity_property'   => 'identity',
                    'credential_property' => 'password',
                    'messages'            => [
                        'success'            => 'Authenticated successfully.',
                        'not_found'          => 'Identity not found.',
                        'invalid_credential' => 'Invalid credentials.',
                    ],
                ],
            ],
        );
        $adapter->setCredential('test');
        $adapter->setIdentity('test@example.com');

        $auth = $adapter->authenticate();

        $this->assertSame(-1, $auth->getCode());
    }

    /**
     * @throws MockObjectException
     * @throws ORMException
     */
    public function testWillNotAuthenticateWithInvalidIdentityPropertyConfig(): void
    {
        $adapter = new AuthenticationAdapter(
            $this->createMock(EntityManager::class),
            [
                'orm_default' => [
                    'identity_class'      => Admin::class,
                    'identity_property'   => 'identity',
                    'credential_property' => 'password',
                    'messages'            => [
                        'success'            => 'Authenticated successfully.',
                        'not_found'          => 'Identity not found.',
                        'invalid_credential' => 'Invalid credentials.',
                    ],
                ],
            ],
        );
        $adapter->setCredential('test');
        $adapter->setIdentity('test@example.com');

        $auth = $adapter->authenticate();

        $this->assertSame(-1, $auth->getCode());
    }

    /**
     * @throws MockObjectException
     * @throws ORMException
     */
    public function testWillNotAuthenticateWithInvalidCredentialPropertyConfig(): void
    {
        $adminRepository = $this->createMock(AdminRepository::class);
        $adminRepository->expects($this->once())->method('findOneBy')->willReturn(
            (new Admin())->setIdentity('test')->setPassword('test')
        );

        $entityManager = $this->createMock(EntityManager::class);
        $entityManager->expects($this->once())->method('getRepository')->willReturn($adminRepository);

        $adapter = new AuthenticationAdapter(
            $entityManager,
            [
                'orm_default' => [
                    'identity_class'      => Admin::class,
                    'identity_property'   => 'identity',
                    'credential_property' => 'test',
                ],
            ],
        );
        $adapter->setCredential('test');
        $adapter->setIdentity('test@example.com');

        $this->expectException(Exception::class);
        $adapter->authenticate();
    }

    /**
     * @throws MockObjectException
     * @throws ORMException
     */
    public function testWillNotAuthenticateWhenInvalidIdentity(): void
    {
        $adminRepository = $this->createMock(AdminRepository::class);
        $adminRepository->expects($this->once())->method('findOneBy')->willReturn(null);

        $entityManager = $this->createMock(EntityManager::class);
        $entityManager->expects($this->once())->method('getRepository')->willReturn($adminRepository);

        $message = 'Identity not found.';
        $adapter = new AuthenticationAdapter(
            $entityManager,
            [
                'orm_default' => [
                    'identity_class'      => Admin::class,
                    'identity_property'   => 'identity',
                    'credential_property' => 'password',
                    'messages'            => [
                        'not_found' => $message,
                    ],
                ],
            ],
        );
        $adapter->setCredential('test');
        $adapter->setIdentity('test@example.com');

        $result = $adapter->authenticate();
        $this->assertContainsEquals($message, $result->getMessages());
    }

    /**
     * @throws MockObjectException
     * @throws ORMException
     */
    public function testWillNotAuthenticateWhenInvalidPassword(): void
    {
        $adminRepository = $this->createMock(AdminRepository::class);
        $adminRepository->expects($this->once())->method('findOneBy')->willReturn(
            (new Admin())
                ->setFirstName('test')
                ->setLastName('test')
                ->setIdentity('test@example.com')
                ->setPassword(password_hash('password', PASSWORD_DEFAULT))
        );

        $entityManager = $this->createMock(EntityManager::class);
        $entityManager->expects($this->once())->method('getRepository')->willReturn($adminRepository);

        $message = 'Invalid credentials.';
        $adapter = new AuthenticationAdapter(
            $entityManager,
            [
                'orm_default' => [
                    'identity_class'      => Admin::class,
                    'identity_property'   => 'identity',
                    'credential_property' => 'password',
                    'messages'            => [
                        'invalid_credential' => $message,
                    ],
                ],
            ],
        );
        $adapter->setCredential('test');
        $adapter->setIdentity('test@example.com');

        $result = $adapter->authenticate();
        $this->assertContainsEquals($message, $result->getMessages());
    }

    /**
     * @throws MockObjectException
     * @throws ORMException
     */
    public function testWillNotAuthenticateWhenInvalidMethodSpecifiedInOptionsConfig(): void
    {
        $adminRepository = $this->createMock(AdminRepository::class);
        $adminRepository->expects($this->once())->method('findOneBy')->willReturn(
            (new Admin())
                ->setFirstName('test')
                ->setLastName('test')
                ->setIdentity('test@example.com')
                ->setPassword(password_hash('password', PASSWORD_DEFAULT))
                ->setStatus(AdminStatusEnum::Active)
        );

        $entityManager = $this->createMock(EntityManager::class);
        $entityManager->expects($this->once())->method('getRepository')->willReturn($adminRepository);

        $adapter = new AuthenticationAdapter(
            $entityManager,
            [
                'orm_default' => [
                    'identity_class'      => Admin::class,
                    'identity_property'   => 'identity',
                    'credential_property' => 'password',
                    'messages'            => [
                        'success' => 'Authenticated successfully.',
                    ],
                    'options'             => [
                        'test' => [
                            'value'   => AdminStatusEnum::Active->value,
                            'message' => 'Unable to sign in because the account is not active.',
                        ],
                    ],
                ],
            ],
        );
        $adapter->setCredential('password');
        $adapter->setIdentity('test@example.com');

        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            sprintf('Method getTest not found in %s', Admin::class)
        );
        $adapter->authenticate();
    }

    /**
     * @throws MockObjectException
     * @throws ORMException
     */
    public function testWillNotAuthenticateWhenMissingValueInOptionsConfig(): void
    {
        $adminRepository = $this->createMock(AdminRepository::class);
        $adminRepository->expects($this->once())->method('findOneBy')->willReturn(
            (new Admin())
                ->setFirstName('test')
                ->setLastName('test')
                ->setIdentity('test@example.com')
                ->setPassword(password_hash('password', PASSWORD_DEFAULT))
                ->setStatus(AdminStatusEnum::Active)
        );

        $entityManager = $this->createMock(EntityManager::class);
        $entityManager->expects($this->once())->method('getRepository')->willReturn($adminRepository);

        $adapter = new AuthenticationAdapter(
            $entityManager,
            [
                'orm_default' => [
                    'identity_class'      => Admin::class,
                    'identity_property'   => 'identity',
                    'credential_property' => 'password',
                    'messages'            => [
                        'success' => 'Authenticated successfully.',
                    ],
                    'options'             => [
                        'status' => [
                            'message' => 'Unable to sign in because the account is not active.',
                        ],
                    ],
                ],
            ],
        );
        $adapter->setCredential('password');
        $adapter->setIdentity('test@example.com');

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Option "value" not provided for "status" option.');
        $adapter->authenticate();
    }

    /**
     * @throws MockObjectException
     * @throws ORMException
     */
    public function testWillNotAuthenticateWhenMissingMessageInOptionsConfig(): void
    {
        $adminRepository = $this->createMock(AdminRepository::class);
        $adminRepository->expects($this->once())->method('findOneBy')->willReturn(
            (new Admin())
                ->setFirstName('test')
                ->setLastName('test')
                ->setIdentity('test@example.com')
                ->setPassword(password_hash('password', PASSWORD_DEFAULT))
                ->setStatus(AdminStatusEnum::Active)
        );

        $entityManager = $this->createMock(EntityManager::class);
        $entityManager->expects($this->once())->method('getRepository')->willReturn($adminRepository);

        $adapter = new AuthenticationAdapter(
            $entityManager,
            [
                'orm_default' => [
                    'identity_class'      => Admin::class,
                    'identity_property'   => 'identity',
                    'credential_property' => 'password',
                    'messages'            => [
                        'success' => 'Authenticated successfully.',
                    ],
                    'options'             => [
                        'status' => [
                            'value' => AdminStatusEnum::Active,
                        ],
                    ],
                ],
            ],
        );
        $adapter->setCredential('password');
        $adapter->setIdentity('test@example.com');

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Option "message" not provided for "status" option.');
        $adapter->authenticate();
    }

    /**
     * @throws MockObjectException
     * @throws ORMException
     */
    public function testWillAuthenticateWithOptionsConfig(): void
    {
        $adminRepository = $this->createMock(AdminRepository::class);
        $adminRepository->expects($this->once())->method('findOneBy')->willReturn(
            (new Admin())
                ->setFirstName('test')
                ->setLastName('test')
                ->setIdentity('test@example.com')
                ->setPassword(password_hash('password', PASSWORD_DEFAULT))
                ->setStatus(AdminStatusEnum::Active)
        );

        $entityManager = $this->createMock(EntityManager::class);
        $entityManager->expects($this->once())->method('getRepository')->willReturn($adminRepository);

        $message = 'Authenticated successfully.';
        $adapter = new AuthenticationAdapter(
            $entityManager,
            [
                'orm_default' => [
                    'identity_class'      => Admin::class,
                    'identity_property'   => 'identity',
                    'credential_property' => 'password',
                    'messages'            => [
                        'success' => $message,
                    ],
                    'options'             => [
                        'status' => [
                            'value'   => AdminStatusEnum::Active->value,
                            'message' => 'Unable to sign in because the account is not active.',
                        ],
                    ],
                ],
            ],
        );
        $adapter->setCredential('password');
        $adapter->setIdentity('test@example.com');

        $result = $adapter->authenticate();
        $this->assertContainsEquals($message, $result->getMessages());
    }

    /**
     * @throws MockObjectException
     * @throws ORMException
     */
    public function testWillAuthenticateWithoutOptionsConfig(): void
    {
        $adminRepository = $this->createMock(AdminRepository::class);
        $adminRepository->expects($this->once())->method('findOneBy')->willReturn(
            (new Admin())
                ->setFirstName('test')
                ->setLastName('test')
                ->setIdentity('test@example.com')
                ->setPassword(password_hash('password', PASSWORD_DEFAULT))
        );

        $entityManager = $this->createMock(EntityManager::class);
        $entityManager->expects($this->once())->method('getRepository')->willReturn($adminRepository);

        $message = 'Authenticated successfully.';
        $adapter = new AuthenticationAdapter(
            $entityManager,
            [
                'orm_default' => [
                    'identity_class'      => Admin::class,
                    'identity_property'   => 'identity',
                    'credential_property' => 'password',
                    'messages'            => [
                        'success' => $message,
                    ],
                ],
            ],
        );
        $adapter->setCredential('password');
        $adapter->setIdentity('test@example.com');

        $result = $adapter->authenticate();
        $this->assertContainsEquals($message, $result->getMessages());
    }
}
