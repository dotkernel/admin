<?php

declare(strict_types=1);

namespace AdminTest\Unit\App\Handler\Page;

use Admin\App\Handler\Page\ComponentHandler;
use AdminTest\Unit\UnitTest;
use Fig\Http\Message\StatusCodeInterface;
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
        $handler = new ComponentHandler($this->createMock(TemplateRendererInterface::class));

        $this->assertInstanceOf(ComponentHandler::class, $handler);
    }

    /**
     * @throws Exception
     */
    public function testWillReturnHtmlTemplate(): void
    {
        $template = $this->createMock(TemplateRendererInterface::class);
        $request  = $this->createMock(ServerRequestInterface::class);

        $template->method('render')->willReturn('<p>test</p>');
        $handler = new ComponentHandler($template);

        $response = $handler->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
