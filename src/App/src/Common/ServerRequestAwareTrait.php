<?php

declare(strict_types=1);

namespace Frontend\App\Common;

use Exception;
use Fig\Http\Message\RequestMethodInterface;

use function array_key_exists;
use function array_map;
use function is_array;
use function sprintf;

trait ServerRequestAwareTrait
{
    public function isDelete(): bool
    {
        return $this->request->getMethod() === RequestMethodInterface::METHOD_DELETE;
    }

    public function isGet(): bool
    {
        return $this->request->getMethod() === RequestMethodInterface::METHOD_GET;
    }

    public function isPatch(): bool
    {
        return $this->request->getMethod() === RequestMethodInterface::METHOD_PATCH;
    }

    public function isPost(): bool
    {
        return $this->request->getMethod() === RequestMethodInterface::METHOD_POST;
    }

    public function isPut(): bool
    {
        return $this->request->getMethod() === RequestMethodInterface::METHOD_PUT;
    }

    public function getPostParams(?callable $callback = null): array|null|object
    {
        $body = $this->request->getParsedBody();
        if (is_array($body)) {
            return $callback ? array_map($callback, $body) : $body;
        }

        return $body;
    }

    public function getPostParam(string $name, mixed $default = null, ?string $cast = null): mixed
    {
        if (array_key_exists($name, $this->request->getParsedBody())) {
            return $this->cast($this->request->getParsedBody()[$name], $cast);
        }

        return $this->cast($default, $cast);
    }

    public function getUploadedFiles(?callable $callback = null): array
    {
        if ($callback) {
            return array_map($callback, $this->request->getUploadedFiles());
        }

        return $this->request->getUploadedFiles();
    }

    /**
     * @throws Exception
     */
    public function getUploadedFile(string $name, ?callable $callback = null): mixed
    {
        if (! array_key_exists($name, $this->request->getUploadedFiles())) {
            throw new Exception(
                sprintf('There is no file uploaded under the name: %s', $name)
            );
        }

        if ($callback) {
            return $callback($this->request->getUploadedFiles()[$name]);
        }

        return $this->request->getUploadedFiles()[$name];
    }

    public function getQueryParams(?callable $callback = null): array
    {
        if ($callback) {
            return array_map($callback, $this->request->getQueryParams());
        }

        return $this->request->getQueryParams();
    }

    public function getQueryParam(string $name, mixed $default = null, ?string $cast = null): mixed
    {
        if (array_key_exists($name, $this->request->getQueryParams())) {
            return $this->cast($this->request->getQueryParams()[$name], $cast);
        }

        return $this->cast($default, $cast);
    }

    public function getCookieParams(?callable $callback = null): array
    {
        if ($callback) {
            return array_map($callback, $this->request->getCookieParams());
        }

        return $this->request->getCookieParams();
    }

    public function getCookieParam(string $name, mixed $default = null, ?string $cast = null): mixed
    {
        if (array_key_exists($name, $this->request->getCookieParams())) {
            return $this->cast($this->request->getCookieParams()[$name], $cast);
        }

        return $this->cast($default, $cast);
    }

    public function getServerParams(?callable $callback = null): array
    {
        if ($callback) {
            return array_map($callback, $this->request->getServerParams());
        }

        return $this->request->getServerParams();
    }

    public function getServerParam(string $name, mixed $default = null, ?string $cast = null): mixed
    {
        if (array_key_exists($name, $this->request->getServerParams())) {
            return $this->cast($this->request->getServerParams()[$name], $cast);
        }

        return $this->cast($default, $cast);
    }

    public function getHeaders(?callable $callback = null): array
    {
        if ($callback) {
            return array_map($callback, $this->request->getHeaders());
        }

        return $this->request->getHeaders();
    }

    public function getHeader(string $name, mixed $default = null, ?string $cast = null): mixed
    {
        if (array_key_exists($name, $this->request->getHeaders())) {
            return $this->cast($this->request->getHeaderLine($name), $cast);
        }

        return $this->cast($default, $cast);
    }

    public function getAttributes(?callable $callback = null): array
    {
        if ($callback) {
            return array_map($callback, $this->request->getAttributes());
        }

        return $this->request->getAttributes();
    }

    public function getAttribute(string $name, mixed $default = null, ?string $cast = null): mixed
    {
        if (array_key_exists($name, $this->request->getAttributes())) {
            return $this->cast($this->request->getAttributes()[$name], $cast);
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
