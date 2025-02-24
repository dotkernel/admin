<?php

declare(strict_types=1);

namespace Admin\App\Common;

use Psr\Http\Message\ServerRequestInterface;

interface ServerRequestAwareInterface
{
    public function isDelete(ServerRequestInterface $request): bool;

    public function isGet(ServerRequestInterface $request): bool;

    public function isPatch(ServerRequestInterface $request): bool;

    public function isPost(ServerRequestInterface $request): bool;

    public function isPut(ServerRequestInterface $request): bool;

    public function getPostParams(ServerRequestInterface $request, ?callable $callback = null): array|null|object;

    public function getPostParam(ServerRequestInterface $request, string $name, mixed $default = null, ?string $cast = null): mixed;

    public function getUploadedFiles(ServerRequestInterface $request, ?callable $callback = null): array;

    public function getUploadedFile(ServerRequestInterface $request, string $name, ?callable $callback = null): mixed;

    public function getQueryParams(ServerRequestInterface $request, ?callable $callback = null): array;

    public function getQueryParam(ServerRequestInterface $request, string $name, mixed $default = null, ?string $cast = null): mixed;

    public function getCookieParams(ServerRequestInterface $request, ?callable $callback = null): array;

    public function getCookieParam(ServerRequestInterface $request, string $name, mixed $default = null, ?string $cast = null): mixed;

    public function getServerParams(ServerRequestInterface $request, ?callable $callback = null): array;

    public function getServerParam(ServerRequestInterface $request, string $name, mixed $default = null, ?string $cast = null): mixed;

    public function getHeaders(ServerRequestInterface $request, ?callable $callback = null): array;

    public function getHeader(ServerRequestInterface $request, string $name, mixed $default = null, ?string $cast = null): mixed;

    public function getAttributes(ServerRequestInterface $request, ?callable $callback = null): array;

    public function getAttribute(ServerRequestInterface $request, string $name, mixed $default = null, ?string $cast = null): mixed;
}
