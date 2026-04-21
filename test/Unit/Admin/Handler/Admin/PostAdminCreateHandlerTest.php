<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Admin;

use Admin\Admin\Form\CreateAdminForm;
use Admin\Admin\Handler\Admin\PostCreateAdminHandler;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Exception\ConflictException;
use AdminTest\Unit\UnitTest;
use Core\App\Message;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Log\Logger;
use Exception;
use Fig\Http\Message\StatusCodeInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception as MockObjectException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use Psr\Http\Message\ServerRequestInterface;

class PostAdminCreateHandlerTest extends UnitTest
{
    private Stub&AdminServiceInterface $adminService;
    private Stub&RouterInterface $router;
    private Stub&TemplateRendererInterface $template;
    private MockObject&FlashMessengerInterface $messenger;
    private Stub&CreateAdminForm $adminForm;
    private Logger $logger;
    private Stub&ServerRequestInterface $request;

    /**
     * @throws MockObjectException
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->adminService = $this->createStub(AdminServiceInterface::class);
        $this->router       = $this->createStub(RouterInterface::class);
        $this->template     = $this->createStub(TemplateRendererInterface::class);
        $this->messenger    = $this->createMock(FlashMessengerInterface::class);
        $this->adminForm    = $this->createStub(CreateAdminForm::class);
        $this->request      = $this->createStub(ServerRequestInterface::class);
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
            ->with(Message::ADMIN_CREATED);

        $handler = new PostCreateAdminHandler(
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
        $this->messenger->expects($this->never())->method('addError');
        $this->messenger->expects($this->never())->method('addSuccess');

        $handler = new PostCreateAdminHandler(
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
        $this->messenger->expects($this->never())->method('addError');
        $this->messenger->expects($this->never())->method('addSuccess');

        $this->throwException(new ConflictException());

        $handler = new PostCreateAdminHandler(
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
        $this->messenger->expects($this->never())->method('addError');
        $this->messenger->expects($this->never())->method('addSuccess');

        $this->throwException(new Exception());

        $handler = new PostCreateAdminHandler(
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
