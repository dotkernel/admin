<?php

declare(strict_types=1);

namespace Frontend\User\Authentication;

use Doctrine\ORM\EntityManager;
use Frontend\User\Entity\Admin;
use Frontend\User\Entity\AdminIdentity;
use Frontend\User\Entity\AdminRole;
use Laminas\Authentication\Adapter\AdapterInterface;
use Exception;
use Laminas\Authentication\Result;

class AuthenticationAdapter implements AdapterInterface
{
    private const METHOD_NOT_EXISTS = "Method %s not found in %s .";
    private const OPTION_VALUE_NOT_PROVIDED = "Option '%s' not provided for '%s' option.";

    private ?string $identity = null;

    private ?string $credential = null;

    private EntityManager $entityManager;

    private array $config = [];

    /**
     * AuthenticationAdapter constructor.
     * @param EntityManager $entityManager
     * @param array $config
     */
    public function __construct(EntityManager $entityManager, array $config)
    {
        $this->entityManager = $entityManager;
        $this->config = $config;
    }

    /**
     * @param string $identity
     * @return $this
     */
    public function setIdentity(string $identity): self
    {
        $this->identity = $identity;
        return $this;
    }

    /**
     * @param string $credential
     * @return $this
     */
    public function setCredential(string $credential): self
    {
        $this->credential = $credential;
        return $this;
    }

    /**
     * @return string
     */
    private function getIdentity(): string
    {
        return $this->identity;
    }

    /**
     * @return string
     */
    private function getCredential(): string
    {
        return $this->credential;
    }

    /**
     * @return Result
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
            $this->config['orm_default']['identity_property'] => $this->getIdentity()
        ]);

        if (null === $identityClass) {
            return new Result(
                Result::FAILURE_IDENTITY_NOT_FOUND,
                null,
                [$this->config['orm_default']['messages']['not_found']]
            );
        }

        $getCredential = "get" . ucfirst($this->config['orm_default']['credential_property']);

        /** Check if get credential method exist in the provided identity class */
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
                'lastName' => $identityClass->getLastName()
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
    private function validateConfig()
    {
        if (
            ! isset($this->config['orm_default']['identity_class']) ||
            ! class_exists($this->config['orm_default']['identity_class'])
        ) {
            throw new Exception("No or invalid param 'identity_class' provided.");
        }

        if (! isset($this->config['orm_default']['identity_property'])) {
            throw new Exception("No or invalid param 'identity_class' provided.");
        }

        if (! isset($this->config['orm_default']['credential_property'])) {
            throw new Exception("No or invalid param 'credential_property' provided.");
        }

        if (empty($this->identity) || empty($this->credential)) {
            throw new Exception('No credentials provided.');
        }
    }

    /**
     * @param $identityClass
     * @param string $methodName
     * @throws Exception
     */
    private function checkMethod($identityClass, string $methodName): void
    {
        if (! method_exists($identityClass, $methodName)) {
            throw new Exception(sprintf(
                self::METHOD_NOT_EXISTS,
                $methodName,
                get_class($identityClass)
            ));
        }
    }
}
