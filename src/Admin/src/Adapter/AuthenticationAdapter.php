<?php

declare(strict_types=1);

namespace Admin\Admin\Adapter;

use Core\Admin\Entity\Admin;
use Core\Admin\Entity\AdminIdentity;
use Core\App\Entity\RoleInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Dot\DependencyInjection\Attribute\Inject;
use Exception;
use Laminas\Authentication\Adapter\AdapterInterface;
use Laminas\Authentication\Result;

use function array_key_exists;
use function array_map;
use function class_exists;
use function method_exists;
use function password_verify;
use function sprintf;
use function ucfirst;

class AuthenticationAdapter implements AdapterInterface
{
    private const METHOD_NOT_EXISTS         = 'Method %s not found in %s.';
    private const OPTION_VALUE_NOT_PROVIDED = 'Option "%s" not provided for "%s" option.';

    private string $identity;
    private string $credential;

    /**
     * @param array<non-empty-string, mixed> $config
     */
    #[Inject(
        EntityManagerInterface::class,
        'config.doctrine.authentication',
    )]
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly array $config,
    ) {
    }

    public function setIdentity(string $identity): self
    {
        $this->identity = $identity;

        return $this;
    }

    public function setCredential(string $credential): self
    {
        $this->credential = $credential;

        return $this;
    }

    private function getIdentity(): string
    {
        return $this->identity;
    }

    private function getCredential(): string
    {
        return $this->credential;
    }

    /**
     * @throws Exception
     * @throws ORMException
     */
    public function authenticate(): Result
    {
        /** Check for the authentication configuration */
        $this->validateConfig();

        /** Get the identity class object */
        $repository = $this->entityManager->getRepository($this->config['orm_default']['identity_class']);

        /** @var Admin $identityClass */
        $identityClass = $repository->findOneBy([
            $this->config['orm_default']['identity_property'] => $this->getIdentity(),
        ]);

        if (null === $identityClass) {
            return new Result(
                Result::FAILURE_IDENTITY_NOT_FOUND,
                null,
                [$this->config['orm_default']['messages']['not_found']]
            );
        }
        $this->entityManager->refresh($identityClass);

        /** Check if the get credential method exists in the provided identity class */
        $getCredential = $this->validateMethod($identityClass, $this->config['orm_default']['credential_property']);

        /** If passwords don't match, return a failure response */
        if (false === password_verify($this->getCredential(), $identityClass->$getCredential())) {
            return new Result(
                Result::FAILURE_CREDENTIAL_INVALID,
                null,
                [$this->config['orm_default']['messages']['invalid_credential']]
            );
        }

        /** Check for extra validation options */
        if (! empty($this->config['orm_default']['options'])) {
            foreach ($this->config['orm_default']['options'] as $property => $option) {
                /** Check if the value for the current option is provided */
                if (! array_key_exists('value', $option)) {
                    throw new Exception(sprintf(
                        self::OPTION_VALUE_NOT_PROVIDED,
                        'value',
                        $property
                    ));
                }

                /** Check if a message for the current option is provided */
                if (! array_key_exists('message', $option)) {
                    throw new Exception(sprintf(
                        self::OPTION_VALUE_NOT_PROVIDED,
                        'message',
                        $property
                    ));
                }

                /** Check if the method exists in the provided identity class */
                $methodName = $this->validateMethod($identityClass, $property);
                if ($identityClass->$methodName()->value !== $option['value']) {
                    return new Result(
                        Result::FAILURE,
                        null,
                        [$option['message']]
                    );
                }
            }
        }

        /** @var non-empty-string[] $roles */
        $roles = array_map(
            fn (RoleInterface $role): string => (string) $role->getName()->value,
            $identityClass->getRoles()
        );

        $adminIdentity = new AdminIdentity(
            $identityClass->getUuid()->toString(),
            $identityClass->getIdentity(),
            $identityClass->getStatus(),
            $roles,
            [
                'firstName' => (string) $identityClass->getFirstName(),
                'lastName'  => (string) $identityClass->getLastName(),
            ]
        );

        return new Result(
            Result::SUCCESS,
            $adminIdentity,
            [$this->config['orm_default']['messages']['success']]
        );
    }

    /**
     * @throws Exception
     */
    private function validateConfig(): void
    {
        if (
            ! isset($this->config['orm_default']['identity_class'])
            || ! class_exists($this->config['orm_default']['identity_class'])
        ) {
            throw new Exception('No or invalid param "identity_class" provided.');
        }

        if (! isset($this->config['orm_default']['identity_property'])) {
            throw new Exception('No or invalid param "identity_property" provided.');
        }

        if (! isset($this->config['orm_default']['credential_property'])) {
            throw new Exception('No or invalid param "credential_property" provided.');
        }

        if (empty($this->identity) || empty($this->credential)) {
            throw new Exception('No credentials provided.');
        }
    }

    /**
     * @throws Exception
     */
    private function validateMethod(Admin $identityClass, string $property): string
    {
        $methodName = sprintf('get%s', ucfirst($property));
        if (! method_exists($identityClass, $methodName)) {
            throw new Exception(sprintf(
                self::METHOD_NOT_EXISTS,
                $methodName,
                $identityClass::class
            ));
        }

        return $methodName;
    }
}
