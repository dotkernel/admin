<?php

declare(strict_types=1);

namespace FrontendTest\Functional;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

trait HttpResponseTrait
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getResponse(ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->getApp()->handle($request);
        $response->getBody()->rewind();

        return $response;
    }
}
