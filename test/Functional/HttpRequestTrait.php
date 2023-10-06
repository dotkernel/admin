<?php

declare(strict_types=1);

namespace FrontendTest\Functional;

use Fig\Http\Message\RequestMethodInterface;
use Laminas\Diactoros\ServerRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

trait HttpRequestTrait
{
    /**
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
