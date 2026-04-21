<?php

declare(strict_types=1);

namespace AdminTest\Unit\Page\Handler;

use Admin\Page\Handler\GetViewPageHandler;
use AdminTest\Unit\UnitTest;
use Fig\Http\Message\StatusCodeInterface;
use Mezzio\Router\RouteResult;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Http\Message\ServerRequestInterface;

class GetPageViewHandlerTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testPageWillReturnHtmlTemplate(): void
    {
        $request     = $this->createStub(ServerRequestInterface::class);
        $routeResult = $this->createStub(RouteResult::class);
        $template    = $this->createStub(TemplateRendererInterface::class);

        $routeResult->method('getMatchedRouteName')->willReturn('test');
        $template->method('render')->willReturn('<p></p>');

        $request
            ->method('getAttribute')
            ->willReturn($routeResult);

        $handler = new GetViewPageHandler($template);

        $response = $handler->handle($request);

        $this->assertSame($response->getHeader('content-type')[0], 'text/html; charset=utf-8');
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
