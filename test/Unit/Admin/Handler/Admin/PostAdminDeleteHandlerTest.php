<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Admin;

use Admin\Admin\Form\DeleteAdminForm;
use Admin\Admin\Handler\Admin\PostDeleteAdminHandler;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Exception\NotFoundException;
use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\Admin;
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
use Ramsey\Uuid\Uuid;

class PostAdminDeleteHandlerTest extends UnitTest
{
    private MockObject&AdminServiceInterface $adminService;
    private Stub&RouterInterface $router;
    private Stub&TemplateRendererInterface $template;
    private MockObject&FlashMessengerInterface $messenger;
    private Stub&DeleteAdminForm $form;
    private Logger $logger;
    private Stub&ServerRequestInterface $request;

    /**
     * @throws MockObjectException
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->adminService = $this->createMock(AdminServiceInterface::class);
        $this->router       = $this->createStub(RouterInterface::class);
        $this->template     = $this->createStub(TemplateRendererInterface::class);
        $this->messenger    = $this->createMock(FlashMessengerInterface::class);
        $this->form         = $this->createStub(DeleteAdminForm::class);
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

    public function testDeleteAdminInvalidAdminProvidedWillReturnNotFoundResponse(): void
    {
        $this->request->method('getAttribute')->willReturn('test');
        $this->adminService
            ->expects($this->once())
            ->method('findAdmin')
            ->willThrowException(new NotFoundException(Message::ADMIN_NOT_FOUND));

        $this
            ->messenger
            ->expects($this->once())
            ->method('addError')
            ->with(Message::ADMIN_NOT_FOUND);

        $handler = new PostDeleteAdminHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->messenger,
            $this->form,
            $this->logger
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * @throws MockObjectException
     */
    public function testDeleteAdminValidFormDataProvidedWillFlashSuccessMessage(): void
    {
        $id    = $this->createStub(Uuid::class);
        $admin = $this->createStub(Admin::class);

        $id->method('toString')->willReturn('0x123');
        $admin->method('getId')->willReturn($id);

        $this->request->method('getAttribute')->willReturn($id->toString());
        $this->adminService->method('findAdmin')->willReturn($admin);

        $this->request->method('getParsedBody')->willReturn([]);
        $this->form->method('isValid')->willReturn(true);

        $this
            ->messenger
            ->expects($this->once())
            ->method('addSuccess')
            ->with(Message::ADMIN_DELETED);

        $this->adminService->expects($this->once())->method('deleteAdmin')->with($admin);

        $handler = new PostDeleteAdminHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->messenger,
            $this->form,
            $this->logger
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_CREATED, $response->getStatusCode());
    }

    /**
     * @throws MockObjectException
     */
    public function testDeleteAdminInvalidFormDataProvidedWillReturnHtmlResponse(): void
    {
        $id    = $this->createStub(Uuid::class);
        $admin = $this->createStub(Admin::class);

        $id->method('toString')->willReturn('0x123');
        $admin->method('getId')->willReturn($id);

        $this->request->method('getAttribute')->willReturn($id->toString());
        $this->adminService->method('findAdmin')->with($id->toString())->willReturn($admin);

        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->form->method('isValid')->willReturn(false);
        $this->form->method('getData')->willReturn([]);

        $this->messenger->expects($this->never())->method('addError');
        $this->messenger->expects($this->never())->method('addSuccess');

        $handler = new PostDeleteAdminHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->messenger,
            $this->form,
            $this->logger
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * @throws MockObjectException
     */
    public function testDeleteAdminThrowsErrorWillReturnEmptyResponse(): void
    {
        $this->request->method('getAttribute')->willReturn('test');
        $this->adminService
            ->expects($this->once())
            ->method('findAdmin')
            ->willReturn(new Admin());
        $this->form->method('setData')->willThrowException(new Exception('test'));

        $this
            ->messenger
            ->expects($this->once())
            ->method('addError');

        $handler = new PostDeleteAdminHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->messenger,
            $this->form,
            $this->logger
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }
}
