<?php

declare(strict_types=1);

namespace AdminTest\Functional;

use Fig\Http\Message\RequestMethodInterface;
use Laminas\Diactoros\ServerRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

trait HttpRequestTrait
{
    /**
     * @param non-empty-string $uri
     * @param array<non-empty-string, mixed> $queryParams
     * @param array<non-empty-string, UploadedFileInterface> $uploadedFiles
     * @param array<non-empty-string, mixed> $headers
     * @param array<non-empty-string, mixed> $cookies
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function get(
        string $uri,
        array $queryParams = [],
        array $uploadedFiles = [],
        array $headers = [],
        array $cookies = []
    ): ResponseInterface {
        $request = $this->createRequest(
            $uri,
            RequestMethodInterface::METHOD_GET,
            [],
            $queryParams,
            $uploadedFiles,
            $headers,
            $cookies,
        );

        return $this->getResponse($request);
    }

    /**
     * @param non-empty-string $uri
     * @param non-empty-string $method
     * @param array<non-empty-string, mixed> $parsedBody
     * @param array<non-empty-string, mixed> $queryParams
     * @param array<non-empty-string, UploadedFileInterface> $uploadedFiles
     * @param array<non-empty-string, mixed> $headers
     * @param array<non-empty-string, mixed> $cookies
     * @param array<non-empty-string, mixed> $serverParams
     * @param non-empty-string $body
     * @param non-empty-string $protocol
     */
    private function createRequest(
        string $uri,
        string $method,
        array $parsedBody = [],
        array $queryParams = [],
        array $uploadedFiles = [],
        array $headers = [],
        array $cookies = [],
        array $serverParams = [],
        string $body = 'php://input',
        string $protocol = '1.1'
    ): ServerRequestInterface {
        return new ServerRequest(
            $serverParams,
            $uploadedFiles,
            $uri,
            $method,
            $body,
            $headers,
            $cookies,
            $queryParams,
            $parsedBody,
            $protocol,
        );
    }
}
