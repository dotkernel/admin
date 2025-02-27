<?php

declare(strict_types=1);

namespace AdminTest\Unit\Dashboard\Handler;

use Admin\Dashboard\Handler\GetDashboardViewHandler;
use AdminTest\Unit\UnitTest;
use Fig\Http\Message\StatusCodeInterface;
use Mezzio\Router\RouteResult;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Http\Message\ServerRequestInterface;

class GetDashboardViewHandlerTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testPageWillReturnHtmlTemplate(): void
    {
        $request     = $this->createMock(ServerRequestInterface::class);
        $routeResult = $this->createMock(RouteResult::class);
        $template    = $this->createMock(TemplateRendererInterface::class);

        $routeResult->method('getMatchedRouteName')->willReturn('test');
        $template->method('render')->willReturn('<p></p>');

        $request
            ->method('getAttribute')
            ->with(RouteResult::class)
            ->willReturn($routeResult);

        $handler = new GetDashboardViewHandler($template);

        $response = $handler->handle($request);

        $this->assertSame($response->getHeader('content-type')[0], 'text/html; charset=utf-8');
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
