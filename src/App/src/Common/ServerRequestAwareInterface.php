<?php

declare(strict_types=1);

namespace Frontend\App\Common;

interface ServerRequestAwareInterface
{
    public function isDelete(): bool;

    public function isGet(): bool;

    public function isPatch(): bool;

    public function isPost(): bool;

    public function isPut(): bool;

    public function getPostParams(?callable $callback = null): array|null|object;

    public function getPostParam(string $name, mixed $default = null, ?string $cast = null): mixed;

    public function getUploadedFiles(?callable $callback = null): array;

    public function getUploadedFile(string $name, ?callable $callback = null): mixed;

    public function getQueryParams(?callable $callback = null): array;

    public function getQueryParam(string $name, mixed $default = null, ?string $cast = null): mixed;

    public function getCookieParams(?callable $callback = null): array;

    public function getCookieParam(string $name, mixed $default = null, ?string $cast = null): mixed;

    public function getServerParams(?callable $callback = null): array;

    public function getServerParam(string $name, mixed $default = null, ?string $cast = null): mixed;

    public function getHeaders(?callable $callback = null): array;

    public function getHeader(string $name, mixed $default = null, ?string $cast = null): mixed;

    public function getAttributes(?callable $callback = null): array;

    public function getAttribute(string $name, mixed $default = null, ?string $cast = null): mixed;
}
