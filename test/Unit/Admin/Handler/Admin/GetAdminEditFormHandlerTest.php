<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Admin;

use Admin\Admin\Entity\Admin;
use Admin\Admin\Form\AdminForm;
use Admin\Admin\Handler\Admin\GetAdminEditFormHandler;
use Admin\Admin\Repository\AdminRepository;
use Admin\Admin\Service\AdminRoleServiceInterface;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Message;
use AdminTest\Unit\UnitTest;
use Dot\FlashMessenger\FlashMessengerInterface;
use Fig\Http\Message\StatusCodeInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;

class GetAdminEditFormHandlerTest extends UnitTest
{
    private MockObject|AdminServiceInterface $adminService;
    private MockObject|AdminRoleServiceInterface $adminRoleService;
    private MockObject|RouterInterface $router;
    private MockObject|TemplateRendererInterface $template;
    private MockObject|FlashMessengerInterface $messenger;
    private MockObject|AdminForm $form;
    private MockObject|AdminRepository $repository;
    private MockObject|ServerRequestInterface $request;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->adminService     = $this->createMock(AdminServiceInterface::class);
        $this->adminRoleService = $this->createMock(AdminRoleServiceInterface::class);
        $this->router           = $this->createMock(RouterInterface::class);
        $this->template         = $this->createMock(TemplateRendererInterface::class);
        $this->messenger        = $this->createMock(FlashMessengerInterface::class);
        $this->form             = $this->createMock(AdminForm::class);
        $this->repository       = $this->createMock(AdminRepository::class);
        $this->request          = $this->createMock(ServerRequestInterface::class);
    }

    public function testInvalidAdminProvidedWillReturnNotFoundResponse(): void
    {
        $this->repository->method('findOneBy')->willReturn(null);
        $this->adminService->method('getAdminRepository')->willReturn($this->repository);

        $this
            ->messenger
            ->expects($this->once())
            ->method('addError')
            ->with(Message::ADMIN_NOT_FOUND);

        $handler = new GetAdminEditFormHandler(
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
     */
    public function testValidAdminWillReturnHtmlTemplate(): void
    {
        $uuid  = $this->createMock(Uuid::class);
        $admin = $this->createMock(Admin::class);

        $uuid->method('toString')->willReturn('0x123');
        $admin->method('getUuid')->willReturn($uuid);

        $this->repository->method('findOneBy')->willReturn($admin);
        $this->adminService->method('getAdminRepository')->willReturn($this->repository);

        $this->template->method('render')->willReturn('<p></p>');

        $handler = new GetAdminEditFormHandler(
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
