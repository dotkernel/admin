<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Admin;

use Admin\Admin\Form\AdminForm;
use Admin\Admin\Handler\Admin\PostAdminCreateHandler;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Exception\IdentityException;
use Admin\App\Message;
use AdminTest\Unit\UnitTest;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Log\Logger;
use Exception;
use Fig\Http\Message\StatusCodeInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception as MockObjectException;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ServerRequestInterface;

class PostAdminCreateHandlerTest extends UnitTest
{
    private MockObject|AdminServiceInterface $adminService;
    private MockObject|RouterInterface $router;
    private MockObject|TemplateRendererInterface $template;
    private MockObject|FlashMessengerInterface $messenger;
    private MockObject|AdminForm $adminForm;
    private Logger $logger;
    private MockObject|ServerRequestInterface $request;

    /**
     * @throws MockObjectException
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->adminService = $this->createMock(AdminServiceInterface::class);
        $this->router       = $this->createMock(RouterInterface::class);
        $this->template     = $this->createMock(TemplateRendererInterface::class);
        $this->messenger    = $this->createMock(FlashMessengerInterface::class);
        $this->adminForm    = $this->createMock(AdminForm::class);
        $this->request      = $this->createMock(ServerRequestInterface::class);
        $this->logger       = new Logger([
            'writers' => [
                'FileWriter' => [
                    'name'     => 'null',
                    'priority' => Logger::ALERT,
                ],
            ],
        ]);
    }

    public function testCreateAdminValidFormDataProvidedWillFlashSuccessMessage(): void
    {
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->adminForm->method('isValid')->willReturn(true);
        $this->adminForm->method('getData')->willReturn([]);

        $this
            ->messenger
            ->expects($this->once())
            ->method('addSuccess')
            ->with(Message::ADMIN_CREATED_SUCCESSFULLY);

        $handler = new PostAdminCreateHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->messenger,
            $this->adminForm,
            $this->logger
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_CREATED, $response->getStatusCode());
    }

    public function testCreateAdminInvalidFormProvidedWillReturnHtmlResponse(): void
    {
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->adminForm->method('isValid')->willReturn(false);
        $this->adminForm->method('getData')->willReturn([]);

        $handler = new PostAdminCreateHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->messenger,
            $this->adminForm,
            $this->logger
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    public function testCreateAdminIdentityExceptionWillReturnHtmlResponse(): void
    {
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->adminForm->method('getData')->willReturn([]);

        $this->throwException(new IdentityException());

        $handler = new PostAdminCreateHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->messenger,
            $this->adminForm,
            $this->logger
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    public function testCreateAdminThrowExceptionWillReturnHtmlResponse(): void
    {
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->adminForm->method('getData')->willReturn([]);

        $this->throwException(new Exception());

        $handler = new PostAdminCreateHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->messenger,
            $this->adminForm,
            $this->logger
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }
}
