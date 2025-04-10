<?php

declare(strict_types=1);

namespace Admin\Admin\Handler\Admin;

use Admin\Admin\Form\EditAdminForm;
use Admin\Admin\Service\AdminRoleServiceInterface;
use Admin\Admin\Service\AdminServiceInterface;
use Core\Admin\Entity\AdminRole;
use Core\App\Exception\NotFoundException;
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
        EditAdminForm::class,
    )]
    public function __construct(
        protected AdminServiceInterface $adminService,
        protected AdminRoleServiceInterface $adminRoleService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected FlashMessengerInterface $messenger,
        protected EditAdminForm $editAdminForm,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $admin = $this->adminService->findAdmin($request->getAttribute('uuid'));
        } catch (NotFoundException $exception) {
            $this->messenger->addError($exception->getMessage());

            return new EmptyResponse(StatusCodeInterface::STATUS_NOT_FOUND);
        }

        $adminRoles = array_map(fn (AdminRole $adminRole): array => [
            'label'    => $adminRole->getName()->value,
            'value'    => $adminRole->getUuid()->toString(),
            'selected' => $admin->hasRole($adminRole),
        ], $this->adminRoleService->getAdminRoleRepository()->findAll());

        $this->editAdminForm
            ->setAttribute(
                'action',
                $this->router->generateUri('admin::admin-edit', ['uuid' => $admin->getUuid()->toString()])
            )
            ->bind($admin)
            ->setRoles($adminRoles);

        return new HtmlResponse(
            $this->template->render('admin::admin-edit-form', [
                'form' => $this->editAdminForm->prepare(),
            ])
        );
    }
}
