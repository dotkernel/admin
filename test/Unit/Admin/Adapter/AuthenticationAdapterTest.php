<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\Adapter;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Persisters\Exception\UnrecognizedField;
use Error;
use Frontend\Admin\Adapter\AuthenticationAdapter;
use Frontend\Admin\Entity\Admin;
use Frontend\Admin\Repository\AdminRepository;
use FrontendTest\Unit\UnitTest;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionException;

use function password_hash;
use function sprintf;

use const PASSWORD_DEFAULT;

class AuthenticationAdapterTest extends UnitTest
{
    /**
     * @throws Exception
     * @throws ReflectionException
     */
    public function testAccessors(): void
    {
        $adapter = new AuthenticationAdapter(
            $this->createMock(EntityManager::class),
            []
        );

        $adapter = $adapter->setIdentity('identity');
        $this->assertInstanceOf(AuthenticationAdapter::class, $adapter);
        $adapter = $adapter->setCredential('credential');
        $this->assertInstanceOf(AuthenticationAdapter::class, $adapter);

        $reflection = new ReflectionClass($adapter);

        $method = $reflection->getMethod('getIdentity');
        $this->assertSame('identity', $method->invoke($adapter));
        $method = $reflection->getMethod('getCredential');
        $this->assertSame('credential', $method->invoke($adapter));
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function testWillNotAuthenticateWithoutValidConfig(): void
    {
        $adapter = new AuthenticationAdapter(
            $this->createMock(EntityManager::class),
            []
        );
        $this->expectExceptionMessage('No or invalid param \'identity_class\' provided.');
        $adapter->authenticate();

        $adapter = new AuthenticationAdapter(
            $this->createMock(EntityManager::class),
            [
                'orm_default' => [
                    'identity_class' => Admin::class,
                ],
            ],
        );
        $this->expectExceptionMessage('No or invalid param \'identity_class\' provided.');
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
        $this->expectExceptionMessage('No or invalid param \'credential_property\' provided.');
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
     * @throws Exception
     * @throws \Exception
     */
    public function testWillNotAuthenticateWithInvalidIdentityClassConfig(): void
    {
        $adapter = new AuthenticationAdapter(
            $this->createMock(EntityManager::class),
            [
                'orm_default' => [
                    'identity_class'      => \Exception::class,
                    'identity_property'   => 'identity',
                    'credential_property' => 'password',
                ],
            ],
        );
        $adapter->setCredential('test');
        $adapter->setIdentity('test@example.com');

        $this->expectException(Error::class);
        $adapter->authenticate();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws \Exception
     */
    public function testWillNotAuthenticateWithInvalidIdentityPropertyConfig(): void
    {
        $adapter = new AuthenticationAdapter(
            $this->getContainer()->get(EntityManager::class),
            [
                'orm_default' => [
                    'identity_class'      => Admin::class,
                    'identity_property'   => 'test',
                    'credential_property' => 'password',
                ],
            ],
        );
        $adapter->setCredential('test');
        $adapter->setIdentity('test@example.com');

        $this->expectException(UnrecognizedField::class);
        $adapter->authenticate();
    }

    /**
     * @throws Exception
     * @throws \Exception
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

        $this->expectException(\Exception::class);
        $adapter->authenticate();
    }

    /**
     * @throws Exception
     * @throws \Exception
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
     * @throws Exception
     * @throws \Exception
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
     * @throws Exception
     * @throws \Exception
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
                ->setStatus(Admin::STATUS_ACTIVE)
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
                            'value'   => Admin::STATUS_ACTIVE,
                            'message' => 'Unable to sign in because the account is not active.',
                        ],
                    ],
                ],
            ],
        );
        $adapter->setCredential('password');
        $adapter->setIdentity('test@example.com');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(
            sprintf('Method getTest not found in %s', Admin::class)
        );
        $adapter->authenticate();
    }

    /**
     * @throws Exception
     * @throws \Exception
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
                ->setStatus(Admin::STATUS_ACTIVE)
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

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Option \'value\' not provided for \'status\' option.');
        $adapter->authenticate();
    }

    /**
     * @throws Exception
     * @throws \Exception
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
                ->setStatus(Admin::STATUS_ACTIVE)
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
                            'value' => Admin::STATUS_ACTIVE,
                        ],
                    ],
                ],
            ],
        );
        $adapter->setCredential('password');
        $adapter->setIdentity('test@example.com');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Option \'message\' not provided for \'status\' option.');
        $adapter->authenticate();
    }

    /**
     * @throws Exception
     * @throws \Exception
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
                ->setStatus(Admin::STATUS_ACTIVE)
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
                            'value'   => Admin::STATUS_ACTIVE,
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
     * @throws Exception
     * @throws \Exception
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
