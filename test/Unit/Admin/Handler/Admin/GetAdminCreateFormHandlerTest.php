<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Admin;

use Admin\Admin\Form\CreateAdminForm;
use Admin\Admin\Handler\Admin\GetCreateAdminFormHandler;
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
        $router   = $this->createStub(RouterInterface::class);
        $template = $this->createStub(TemplateRendererInterface::class);
        $form     = $this->createStub(CreateAdminForm::class);
        $request  = $this->createStub(ServerRequestInterface::class);

        $handler = new GetCreateAdminFormHandler(
            $router,
            $template,
            $form,
        );

        $response = $handler->handle($request);

        $this->assertSame($response->getHeader('content-type')[0], 'text/html; charset=utf-8');
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
