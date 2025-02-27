<?php

declare(strict_types=1);

namespace AdminTest\Functional;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class DashboardTest extends FunctionalTest
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testWillGetDashboard(): void
    {
        $response = $this->get('/');
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
