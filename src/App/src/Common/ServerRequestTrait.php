<?php

declare(strict_types=1);

namespace Frontend\App\Common;

use Exception;
use Fig\Http\Message\RequestMethodInterface;

/**
 * Trait ServerRequestTrait
 * @package Frontend\App\Common
 */
trait ServerRequestTrait
{
    /**
     * Check if request method is DELETE
     * @return bool
     */
    public function isDelete(): bool
    {
        return $this->request->getMethod() === RequestMethodInterface::METHOD_DELETE;
    }

    /**
     * Check if request method is GET
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->request->getMethod() === RequestMethodInterface::METHOD_GET;
    }

    /**
     * Check if request method is PATCH
     * @return bool
     */
    public function isPatch(): bool
    {
        return $this->request->getMethod() === RequestMethodInterface::METHOD_PATCH;
    }

    /**
     * Check if request method is POST
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->request->getMethod() === RequestMethodInterface::METHOD_POST;
    }

    /**
     * Check if request method is PUT
     * @return bool
     */
    public function isPut(): bool
    {
        return $this->request->getMethod() === RequestMethodInterface::METHOD_PUT;
    }

    /**
     * Get all $_POST parameters
     * @param callable|null $callback
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
     * @param string $name
     * @param mixed $default
     * @param string|null $cast
     * @return mixed
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
     * @param callable|null $callback
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
     * @param string $name
     * @param callable|null $callback
     * @return mixed
     * @throws Exception
     */
    public function getUploadedFile(string $name, ?callable $callback = null): mixed
    {
        if (!array_key_exists($name, $this->request->getUploadedFiles())) {
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
     * @param callable|null $callback
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
     * @param string $name
     * @param mixed $default
     * @param string|null $cast
     * @return mixed
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
     * @param callable|null $callback
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
     * @param string $name
     * @param mixed $default
     * @param string|null $cast
     * @return mixed
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
     * @param callable|null $callback
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
     * @param string $name
     * @param mixed $default
     * @param string|null $cast
     * @return mixed
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
     * @param callable|null $callback
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
     * @param string $name
     * @param mixed $default
     * @param string|null $cast
     * @return mixed
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
     * @param callable|null $callback
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
     * @param string $name
     * @param mixed $default
     * @param string|null $cast
     * @return mixed
     */
    public function getAttribute(string $name, mixed $default = null, ?string $cast = null): mixed
    {
        if (array_key_exists($name, $this->request->getAttributes())) {
            return $this->cast($this->request->getAttributes()[$name], $cast);
        }

        return $default;
    }

    /**
     * @param mixed $value
     * @param string|null $to
     * @return mixed
     */
    private function cast(mixed $value, ?string $to = null): mixed
    {
        return match ($to) {
            'array' => (array)$value,
            'bool' => (bool)$value,
            'float' => (float)$value,
            'int' => (int)$value,
            'object' => (object)$value,
            'string' => (string)$value,
            default => $value,
        };
    }
}
