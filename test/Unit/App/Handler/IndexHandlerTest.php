<?php

namespace AdminTest\Unit\App\Handler;

use Admin\App\Handler\GetIndexRedirectHandler;
use AdminTest\Unit\UnitTest;
use Fig\Http\Message\StatusCodeInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Http\Message\ServerRequestInterface;

class IndexHandlerTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testWillCreate(): void
    {
        $handler = new GetIndexRedirectHandler($this->createMock(TemplateRendererInterface::class));

        $this->assertInstanceOf(GetIndexRedirectHandler::class, $handler);
    }

    /**
     * @throws Exception
     */
    public function testWillReturnHtmlTemplate(): void
    {
        $template = $this->createMock(TemplateRendererInterface::class);
        $request = $this->createMock(ServerRequestInterface::class);

        $template->method('render')->willReturn('<p>test</p>');
        $handler = new GetIndexRedirectHandler($template);

        $response = $handler->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}