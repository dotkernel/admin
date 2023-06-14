<?php

declare(strict_types=1);

namespace Frontend\App\Common;

use Exception;
use Fig\Http\Message\RequestMethodInterface;

use function array_key_exists;
use function array_map;
use function is_array;
use function sprintf;

/**
 * Trait ServerRequestTrait
 */
trait ServerRequestTrait
{
    /**
     * Check if request method is DELETE
     */
    public function isDelete(): bool
    {
        return $this->request->getMethod() === RequestMethodInterface::METHOD_DELETE;
    }

    /**
     * Check if request method is GET
     */
    public function isGet(): bool
    {
        return $this->request->getMethod() === RequestMethodInterface::METHOD_GET;
    }

    /**
     * Check if request method is PATCH
     */
    public function isPatch(): bool
    {
        return $this->request->getMethod() === RequestMethodInterface::METHOD_PATCH;
    }

    /**
     * Check if request method is POST
     */
    public function isPost(): bool
    {
        return $this->request->getMethod() === RequestMethodInterface::METHOD_POST;
    }

    /**
     * Check if request method is PUT
     */
    public function isPut(): bool
    {
        return $this->request->getMethod() === RequestMethodInterface::METHOD_PUT;
    }

    /**
     * Get all $_POST parameters
     *
     * @return array
     */
    public function getPostParams(?callable $callback = null): array
    {
        $body = $this->request->getParsedBody();
        if (is_array($body)) {
            if ($callback) {
                return array_map($callback, $body);
            }

            return $body;
        }

        return [];
    }

    /**
     * Get specific $_POST parameter
     */
    public function getPostParam(string $name, mixed $default = null, ?string $cast = null): mixed
    {
        if (array_key_exists($name, $this->request->getParsedBody())) {
            return $this->cast($this->request->getParsedBody()[$name], $cast);
        }

        return $default;
    }

    /**
     * Get all $_FILES parameters
     *
     * @return array
     */
    public function getUploadedFiles(?callable $callback = null): array
    {
        if ($callback) {
            return array_map($callback, $this->request->getUploadedFiles());
        }

        return $this->request->getUploadedFiles();
    }

    /**
     * Get specific $_FILES parameter
     *
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

    /**
     * Get all $_GET parameters
     *
     * @return array
     */
    public function getQueryParams(?callable $callback = null): array
    {
        if ($callback) {
            return array_map($callback, $this->request->getQueryParams());
        }

        return $this->request->getQueryParams();
    }

    /**
     * Get specific $_GET parameter
     */
    public function getQueryParam(string $name, mixed $default = null, ?string $cast = null): mixed
    {
        if (array_key_exists($name, $this->request->getQueryParams())) {
            return $this->cast($this->request->getQueryParams()[$name], $cast);
        }

        return $default;
    }

    /**
     * Get all $_COOKIE parameters
     *
     * @return array
     */
    public function getCookieParams(?callable $callback = null): array
    {
        if ($callback) {
            return array_map($callback, $this->request->getCookieParams());
        }

        return $this->request->getCookieParams();
    }

    /**
     * Get specific $_COOKIE parameter
     */
    public function getCookieParam(string $name, mixed $default = null, ?string $cast = null): mixed
    {
        if (array_key_exists($name, $this->request->getCookieParams())) {
            return $this->cast($this->request->getCookieParams()[$name], $cast);
        }

        return $default;
    }

    /**
     * Get all $_SERVER parameters
     *
     * @return array
     */
    public function getServerParams(?callable $callback = null): array
    {
        if ($callback) {
            return array_map($callback, $this->request->getServerParams());
        }

        return $this->request->getServerParams();
    }

    /**
     * Get specific $_SERVER parameter
     */
    public function getServerParam(string $name, mixed $default = null, ?string $cast = null): mixed
    {
        if (array_key_exists($name, $this->request->getServerParams())) {
            return $this->cast($this->request->getServerParams()[$name], $cast);
        }

        return $default;
    }

    /**
     * Get all headers
     *
     * @return array
     */
    public function getHeaders(?callable $callback = null): array
    {
        if ($callback) {
            return array_map($callback, $this->request->getHeaders());
        }

        return $this->request->getHeaders();
    }

    /**
     * Get specific header
     */
    public function getHeader(string $name, mixed $default = null, ?string $cast = null): mixed
    {
        if (array_key_exists($name, $this->request->getHeaders())) {
            return $this->cast($this->request->getHeader($name), $cast);
        }

        return $default;
    }

    /**
     * Get all request attributes
     *
     * @return array
     */
    public function getAttributes(?callable $callback = null): array
    {
        if ($callback) {
            return array_map($callback, $this->request->getAttributes());
        }

        return $this->request->getAttributes();
    }

    /**
     * Get specific request attribute
     */
    public function getAttribute(string $name, mixed $default = null, ?string $cast = null): mixed
    {
        if (array_key_exists($name, $this->request->getAttributes())) {
            return $this->cast($this->request->getAttributes()[$name], $cast);
        }

        return $default;
    }

    private function cast(mixed $value, ?string $to = null): mixed
    {
        return match ($to) {
            'array' => (array) $value,
            'bool' => (bool) $value,
            'float' => (float) $value,
            'int' => (int) $value,
            'object' => (object) $value,
            'string' => (string) $value,
            default => $value,
        };
    }
}
