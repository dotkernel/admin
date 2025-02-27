<?php

declare(strict_types=1);

namespace AdminTest\Unit\App\Handler;

use Admin\App\Handler\GetComponentViewHandler;
use AdminTest\Unit\UnitTest;
use Fig\Http\Message\StatusCodeInterface;
use Mezzio\Router\RouteResult;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Http\Message\ServerRequestInterface;

class ComponentHandlerTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testWillCreate(): void
    {
        $handler = new GetComponentViewHandler($this->createMock(TemplateRendererInterface::class));

        $this->assertInstanceOf(GetComponentViewHandler::class, $handler);
    }

    /**
     * @throws Exception
     */
    public function testWillReturnHtmlTemplate(): void
    {
        $template = $this->createMock(TemplateRendererInterface::class);
        $request  = $this->createMock(ServerRequestInterface::class);
        $routeResult = $this->createMock(RouteResult::class);

        $routeResult->method('getMatchedRouteName')->willReturn('test');
        $request->method('getAttribute')->with(RouteResult::class)->willReturn($routeResult);
        $template->method('render')->willReturn('<p>test</p>');

        $handler = new GetComponentViewHandler($template);

        $response = $handler->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
