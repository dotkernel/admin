<?php

declare(strict_types=1);

namespace Admin\App\Common;

use Exception;
use Fig\Http\Message\RequestMethodInterface;
use Psr\Http\Message\ServerRequestInterface;

use function array_key_exists;
use function array_map;
use function is_array;
use function sprintf;

trait ServerRequestAwareTrait
{
    public function isDelete(ServerRequestInterface $request): bool
    {
        return $request->getMethod() === RequestMethodInterface::METHOD_DELETE;
    }

    public function isGet(ServerRequestInterface $request): bool
    {
        return $request->getMethod() === RequestMethodInterface::METHOD_GET;
    }

    public function isPatch(ServerRequestInterface $request): bool
    {
        return $request->getMethod() === RequestMethodInterface::METHOD_PATCH;
    }

    public function isPost(ServerRequestInterface $request): bool
    {
        return $request->getMethod() === RequestMethodInterface::METHOD_POST;
    }

    public function isPut(ServerRequestInterface $request): bool
    {
        return $request->getMethod() === RequestMethodInterface::METHOD_PUT;
    }

    public function getPostParams(
        ServerRequestInterface $request,
        ?callable $callback = null
    ): array|null|object {
        $body = $request->getParsedBody();
        if (is_array($body)) {
            return $callback ? array_map($callback, $body) : $body;
        }

        return $body;
    }

    public function getPostParam(
        ServerRequestInterface $request,
        string $name,
        mixed $default = null,
        ?string $cast = null
    ): mixed {
        if (array_key_exists($name, $request->getParsedBody())) {
            return $this->cast($request->getParsedBody()[$name], $cast);
        }

        return $this->cast($default, $cast);
    }

    public function getUploadedFiles(ServerRequestInterface $request, ?callable $callback = null): array
    {
        if ($callback) {
            return array_map($callback, $request->getUploadedFiles());
        }

        return $request->getUploadedFiles();
    }

    /**
     * @throws Exception
     */
    public function getUploadedFile(ServerRequestInterface $request, string $name, ?callable $callback = null): mixed
    {
        if (! array_key_exists($name, $request->getUploadedFiles())) {
            throw new Exception(
                sprintf('There is no file uploaded under the name: %s', $name)
            );
        }

        if ($callback) {
            return $callback($request->getUploadedFiles()[$name]);
        }

        return $request->getUploadedFiles()[$name];
    }

    public function getQueryParams(ServerRequestInterface $request, ?callable $callback = null): array
    {
        if ($callback) {
            return array_map($callback, $request->getQueryParams());
        }

        return $request->getQueryParams();
    }

    public function getQueryParam(
        ServerRequestInterface $request,
        string $name,
        mixed $default = null,
        ?string $cast = null
    ): mixed {
        if (array_key_exists($name, $request->getQueryParams())) {
            return $this->cast($request->getQueryParams()[$name], $cast);
        }

        return $this->cast($default, $cast);
    }

    public function getCookieParams(ServerRequestInterface $request, ?callable $callback = null): array
    {
        if ($callback) {
            return array_map($callback, $request->getCookieParams());
        }

        return $request->getCookieParams();
    }

    public function getCookieParam(
        ServerRequestInterface $request,
        string $name,
        mixed $default = null,
        ?string $cast = null
    ): mixed {
        if (array_key_exists($name, $request->getCookieParams())) {
            return $this->cast($request->getCookieParams()[$name], $cast);
        }

        return $this->cast($default, $cast);
    }

    public function getServerParams(ServerRequestInterface $request, ?callable $callback = null): array
    {
        if ($callback) {
            return array_map($callback, $request->getServerParams());
        }

        return $request->getServerParams();
    }

    public function getServerParam(
        ServerRequestInterface $request,
        string $name,
        mixed $default = null,
        ?string $cast = null
    ): mixed {
        if (array_key_exists($name, $request->getServerParams())) {
            return $this->cast($request->getServerParams()[$name], $cast);
        }

        return $this->cast($default, $cast);
    }

    public function getHeaders(ServerRequestInterface $request, ?callable $callback = null): array
    {
        if ($callback) {
            return array_map($callback, $request->getHeaders());
        }

        return $request->getHeaders();
    }

    public function getHeader(
        ServerRequestInterface $request,
        string $name,
        mixed $default = null,
        ?string $cast = null
    ): mixed {
        if (array_key_exists($name, $request->getHeaders())) {
            return $this->cast($request->getHeaderLine($name), $cast);
        }

        return $this->cast($default, $cast);
    }

    public function getAttributes(ServerRequestInterface $request, ?callable $callback = null): array
    {
        if ($callback) {
            return array_map($callback, $request->getAttributes());
        }

        return $request->getAttributes();
    }

    public function getAttribute(
        ServerRequestInterface $request,
        string $name,
        mixed $default = null,
        ?string $cast = null
    ): mixed {
        if (array_key_exists($name, $request->getAttributes())) {
            return $this->cast($request->getAttributes()[$name], $cast);
        }

        return $this->cast($default, $cast);
    }

    private function cast(mixed $value, ?string $to = null): mixed
    {
        return match ($to) {
            'array'  => (array) $value,
            'bool'   => (bool) $value,
            'float'  => (float) $value,
            'int'    => (int) $value,
            'object' => (object) $value,
            'string' => (string) $value,
            default  => $value,
        };
    }
}
