<?php

declare(strict_types=1);

namespace AdminTest\Functional;

use Fig\Http\Message\StatusCodeInterface;

class DashboardTest extends FunctionalTest
{
    public function testWillGetDashboard(): void
    {
        $response = $this->get('/');
        $this->assertSame(StatusCodeInterface::STATUS_FOUND, $response->getStatusCode());
    }
}
