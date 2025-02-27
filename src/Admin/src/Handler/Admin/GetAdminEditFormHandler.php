<?php

declare(strict_types=1);

namespace Admin\Admin\Handler\Admin;

use Admin\Admin\Entity\Admin;
use Admin\Admin\Entity\AdminRole;
use Admin\Admin\Form\AdminForm;
use Admin\Admin\FormData\AdminFormData;
use Admin\Admin\Service\AdminRoleServiceInterface;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Message;
use Dot\DependencyInjection\Attribute\Inject;
use Dot\FlashMessenger\FlashMessengerInterface;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function array_map;

class GetAdminEditFormHandler implements RequestHandlerInterface
{
    #[Inject(
        AdminServiceInterface::class,
        AdminRoleServiceInterface::class,
        RouterInterface::class,
        TemplateRendererInterface::class,
        FlashMessengerInterface::class,
        AdminForm::class,
    )]
    public function __construct(
        protected AdminServiceInterface $adminService,
        protected AdminRoleServiceInterface $adminRoleService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected FlashMessengerInterface $messenger,
        protected AdminForm $form,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $admin = $this->adminService->getAdminRepository()->findOneBy(['uuid' => $request->getAttribute('uuid')]);
        if (! $admin instanceof Admin) {
            $this->messenger->addError(Message::ADMIN_NOT_FOUND);
            return new EmptyResponse(StatusCodeInterface::STATUS_NOT_FOUND);
        }

        $this->form->setAttribute(
            'action',
            $this->router->generateUri('admin::admin-edit', ['uuid' => $admin->getUuid()->toString()])
        );

        $roles = array_map(function (AdminRole $role) use ($admin): array {
            return [
                'label'    => $role->getName(),
                'value'    => $role->getUuid()->toString(),
                'selected' => $admin->hasRole($role),
            ];
        }, $this->adminRoleService->getRoles());

        $this->form->setRoles($roles);
        $adminFormData = (new AdminFormData())->fromEntity($admin);
        $this->form->bind($adminFormData);

        return new HtmlResponse(
            $this->template->render('admin::edit-admin-modal-content', [
                'form' => $this->form->prepare(),
            ])
        );
    }
}
