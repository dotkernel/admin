<?php

declare(strict_types=1);

namespace Frontend\Admin\Adapter;

use Doctrine\ORM\EntityManager;
use Dot\AnnotatedServices\Annotation\Inject;
use Exception;
use Frontend\Admin\Entity\Admin;
use Frontend\Admin\Entity\AdminIdentity;
use Frontend\Admin\Entity\AdminRole;
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
    private const METHOD_NOT_EXISTS         = "Method %s not found in %s.";
    private const OPTION_VALUE_NOT_PROVIDED = "Option '%s' not provided for '%s' option.";
    private string $identity;
    private string $credential;
    private array $config;

    /**
     * @Inject({
     *     EntityManager::class,
     *     "config.doctrine.authentication"
     * })
     */
    public function __construct(
        private EntityManager $entityManager,
        array $config
    ) {
        $this->config = $config;
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

        $getCredential = "get" . ucfirst($this->config['orm_default']['credential_property']);

        /** Check if the get credential method exists in the provided identity class */
        $this->checkMethod($identityClass, $getCredential);

        /** If passwords don't match, return failure response */
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
                $methodName = "get" . ucfirst($property);

                /** Check if the method exists in the provided identity class */
                $this->checkMethod($identityClass, $methodName);

                /** Check if value for the current option is provided */
                if (! array_key_exists('value', $option)) {
                    throw new Exception(sprintf(
                        self::OPTION_VALUE_NOT_PROVIDED,
                        'value',
                        $property
                    ));
                }

                /** Check if message for the current option is provided */
                if (! array_key_exists('message', $option)) {
                    throw new Exception(sprintf(
                        self::OPTION_VALUE_NOT_PROVIDED,
                        'message',
                        $property
                    ));
                }

                if ($identityClass->$methodName() !== $option['value']) {
                    return new Result(
                        Result::FAILURE,
                        null,
                        [$option['message']]
                    );
                }
            }
        }

        $adminIdentity = new AdminIdentity(
            $identityClass->getUuid()->toString(),
            $identityClass->getIdentity(),
            $identityClass->getStatus(),
            array_map(function (AdminRole $role) {
                return $role->getName();
            }, $identityClass->getRoles()),
            [
                'firstName' => $identityClass->getFirstName(),
                'lastName'  => $identityClass->getLastName(),
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
            ! isset($this->config['orm_default']['identity_class']) ||
            ! class_exists($this->config['orm_default']['identity_class'])
        ) {
            throw new Exception("No or invalid param 'identity_class' provided.");
        }

        if (! isset($this->config['orm_default']['identity_property'])) {
            throw new Exception("No or invalid param 'identity_property' provided.");
        }

        if (! isset($this->config['orm_default']['credential_property'])) {
            throw new Exception("No or invalid param 'credential_property' provided.");
        }

        if (empty($this->identity) || empty($this->credential)) {
            throw new Exception('No credentials provided.');
        }
    }

    /**
     * @throws Exception
     */
    private function checkMethod(Admin $identityClass, string $methodName): void
    {
        if (! method_exists($identityClass, $methodName)) {
            throw new Exception(sprintf(
                self::METHOD_NOT_EXISTS,
                $methodName,
                $identityClass::class
            ));
        }
    }
}
