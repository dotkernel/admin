<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Admin;

use Admin\Admin\Form\CreateAdminForm;
use Admin\Admin\Handler\Admin\GetAdminCreateFormHandler;
use AdminTest\Unit\UnitTest;
use Fig\Http\Message\StatusCodeInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Http\Message\ServerRequestInterface;

class GetAdminCreateFormHandlerTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testWillReturnHtmlTemplate(): void
    {
        $router   = $this->createMock(RouterInterface::class);
        $template = $this->createMock(TemplateRendererInterface::class);
        $form     = $this->createMock(CreateAdminForm::class);
        $request  = $this->createMock(ServerRequestInterface::class);

        $handler = new GetAdminCreateFormHandler(
            $router,
            $template,
            $form,
        );

        $response = $handler->handle($request);

        $this->assertSame($response->getHeader('content-type')[0], 'text/html; charset=utf-8');
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
