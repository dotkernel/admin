<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Admin;

use Admin\Admin\Form\EditAdminForm;
use Admin\Admin\Handler\Admin\GetEditAdminFormHandler;
use Admin\Admin\Service\AdminRoleServiceInterface;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Exception\NotFoundException;
use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\Admin;
use Core\Admin\Enum\AdminStatusEnum;
use Core\App\Message;
use Dot\FlashMessenger\FlashMessengerInterface;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Form\Exception\ExceptionInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;

class GetAdminEditFormHandlerTest extends UnitTest
{
    private Stub&AdminServiceInterface $adminService;
    private Stub&AdminRoleServiceInterface $adminRoleService;
    private Stub&RouterInterface $router;
    private Stub&TemplateRendererInterface $template;
    private MockObject&FlashMessengerInterface $messenger;
    private Stub&EditAdminForm $form;
    private Stub&ServerRequestInterface $request;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->adminService     = $this->createStub(AdminServiceInterface::class);
        $this->adminRoleService = $this->createStub(AdminRoleServiceInterface::class);
        $this->router           = $this->createStub(RouterInterface::class);
        $this->template         = $this->createStub(TemplateRendererInterface::class);
        $this->messenger        = $this->createMock(FlashMessengerInterface::class);
        $this->form             = $this->createStub(EditAdminForm::class);
        $this->request          = $this->createStub(ServerRequestInterface::class);
    }

    public function testInvalidAdminProvidedWillReturnNotFoundResponse(): void
    {
        $this->request->method('getAttribute')->willReturn('test');
        $this->adminService->method('findAdmin')
            ->willThrowException(new NotFoundException(Message::ADMIN_NOT_FOUND));
        $this->messenger->expects($this->once())->method('addError')->with(Message::ADMIN_NOT_FOUND);

        $this
            ->messenger
            ->expects($this->once())
            ->method('addError')
            ->with(Message::ADMIN_NOT_FOUND);

        $handler = new GetEditAdminFormHandler(
            $this->adminService,
            $this->adminRoleService,
            $this->router,
            $this->template,
            $this->messenger,
            $this->form,
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * @throws Exception
     * @throws ExceptionInterface
     */
    public function testValidAdminWillReturnHtmlTemplate(): void
    {
        $id    = $this->createStub(Uuid::class);
        $admin = $this->createStub(Admin::class);

        $id->method('toString')->willReturn('0x123');
        $admin->method('getId')->willReturn($id);
        $admin->method('getStatus')->willReturn(AdminStatusEnum::Active);

        $this->form->method('setAttribute')->willReturn($this->form);
        $this->form->method('bind')->willReturn($this->form);
        $this->request->method('getAttribute')->willReturn($id->toString());
        $this->adminService->method('findAdmin')->willReturn($admin);

        $this->template->method('render')->willReturn('<p></p>');
        $this->messenger->expects($this->never())->method('addError');

        $handler = new GetEditAdminFormHandler(
            $this->adminService,
            $this->adminRoleService,
            $this->router,
            $this->template,
            $this->messenger,
            $this->form,
        );

        $response = $handler->handle($this->request);

        $this->assertSame($response->getHeader('content-type')[0], 'text/html; charset=utf-8');
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
