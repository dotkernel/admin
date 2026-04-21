<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Admin;

use Admin\Admin\Form\EditAdminForm;
use Admin\Admin\Handler\Admin\PostEditAdminHandler;
use Admin\Admin\Service\AdminRoleServiceInterface;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Exception\ConflictException;
use Admin\App\Exception\NotFoundException;
use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\Admin;
use Core\App\Message;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Log\Logger;
use Exception;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Form\Exception\ExceptionInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception as MockObjectException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;

class PostAdminEditHandlerTest extends UnitTest
{
    private MockObject&AdminServiceInterface $adminService;
    private Stub&AdminRoleServiceInterface $adminRoleService;
    private Stub&RouterInterface $router;
    private Stub&TemplateRendererInterface $template;
    private MockObject&FlashMessengerInterface $messenger;
    private Stub&EditAdminForm $form;
    private Logger $logger;
    private Stub&ServerRequestInterface $request;
    private Stub&Admin $admin;
    private Stub&Uuid $id;

    /**
     * @throws MockObjectException
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->adminService     = $this->createMock(AdminServiceInterface::class);
        $this->adminRoleService = $this->createStub(AdminRoleServiceInterface::class);
        $this->router           = $this->createStub(RouterInterface::class);
        $this->template         = $this->createStub(TemplateRendererInterface::class);
        $this->messenger        = $this->createMock(FlashMessengerInterface::class);
        $this->form             = $this->createStub(EditAdminForm::class);
        $this->request          = $this->createStub(ServerRequestInterface::class);
        $this->admin            = $this->createStub(Admin::class);
        $this->id               = $this->createStub(Uuid::class);
        $this->logger           = new Logger([
            'writers' => [
                'FileWriter' => [
                    'name'     => 'null',
                    'priority' => Logger::ALERT,
                ],
            ],
        ]);
    }

    /**
     * @throws ExceptionInterface
     */
    public function testEditAdminInvalidAdminProvidedWillReturnNotFoundResponse(): void
    {
        $this->request->method('getAttribute')->willReturn('test');
        $this->adminService
            ->expects($this->once())
            ->method('findAdmin')
            ->willThrowException(new NotFoundException(Message::ADMIN_NOT_FOUND));
        $this->form->method('isValid')->willReturn(true);
        $this->form->method('getData')->willReturn([]);

        $this->messenger
            ->expects($this->once())
            ->method('addError')
            ->with(Message::ADMIN_NOT_FOUND);

        $handler = new PostEditAdminHandler(
            $this->adminService,
            $this->adminRoleService,
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
     * @throws ExceptionInterface
     * @throws MockObjectException
     */
    public function testEditAdminValidFormDataProvidedWillFlashSuccessMessage(): void
    {
        $this->id->method('toString')->willReturn('0x123');
        $this->admin->method('getId')->willReturn($this->id);
        $this->request->method('getAttribute')->willReturn($this->id->toString());
        $this->adminService->method('findAdmin')->with($this->id->toString())->willReturn($this->admin);
        $this->form->method('setAttribute')->willReturn($this->form);
        $this->request->method('getParsedBody')->willReturn([]);
        $this->form->method('isValid')->willReturn(true);
        $this->form->method('getData')->willReturn([]);

        $this
            ->messenger
            ->expects($this->once())
            ->method('addSuccess')
            ->with(Message::ADMIN_UPDATED);

        $this->adminService->expects($this->once())->method('saveAdmin');

        $handler = new PostEditAdminHandler(
            $this->adminService,
            $this->adminRoleService,
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
     * @throws ExceptionInterface
     * @throws MockObjectException
     */
    public function testEditAdminInvalidFormDataProvidedWillReturnHtmlResponse(): void
    {
        $this->id->method('toString')->willReturn('0x123');
        $this->admin->method('getId')->willReturn($this->id);
        $this->request->method('getAttribute')->willReturn($this->id->toString());
        $this->adminService->method('findAdmin')->with($this->id->toString())->willReturn($this->admin);
        $this->form->method('setAttribute')->willReturn($this->form);
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->form->method('isValid')->willReturn(false);
        $this->form->method('getData')->willReturn([]);
        $this->messenger->expects($this->never())->method('addError');

        $handler = new PostEditAdminHandler(
            $this->adminService,
            $this->adminRoleService,
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
     * @throws ExceptionInterface
     */
    public function testEditAdminThrowConflictExceptionWillReturnHtmlResponse(): void
    {
        $this->id->method('toString')->willReturn('0x123');
        $this->admin->method('getId')->willReturn($this->id);
        $this->request->method('getAttribute')->willReturn($this->id->toString());
        $this->adminService->method('findAdmin')->with($this->id->toString())->willReturn($this->admin);
        $this->form->method('setAttribute')->willReturn($this->form);
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->form->method('isValid')->willReturn(false);
        $this->form->method('getData')->willReturn([]);
        $this->messenger->expects($this->never())->method('addError');

        $handler = new PostEditAdminHandler(
            $this->adminService,
            $this->adminRoleService,
            $this->router,
            $this->template,
            $this->messenger,
            $this->form,
            $this->logger
        );

        $this->throwException(new ConflictException());

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * @throws ExceptionInterface
     */
    public function testEditAdminThrowExceptionWillReturnHtmlResponse(): void
    {
        $this->id->method('toString')->willReturn('0x123');
        $this->admin->method('getId')->willReturn($this->id);
        $this->request->method('getAttribute')->willReturn($this->id->toString());
        $this->adminService->method('findAdmin')->with($this->id->toString())->willReturn($this->admin);
        $this->form->method('setAttribute')->willReturn($this->form);
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->form->method('isValid')->willReturn(false);
        $this->form->method('getData')->willReturn([]);
        $this->messenger->expects($this->never())->method('addError');

        $handler = new PostEditAdminHandler(
            $this->adminService,
            $this->adminRoleService,
            $this->router,
            $this->template,
            $this->messenger,
            $this->form,
            $this->logger
        );

        $this->throwException(new Exception());

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }
}
