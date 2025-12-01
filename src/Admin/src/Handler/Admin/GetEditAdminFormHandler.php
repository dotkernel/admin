<?php

declare(strict_types=1);

namespace Admin\Admin\Handler\Admin;

use Admin\Admin\Form\EditAdminForm;
use Admin\Admin\Service\AdminRoleServiceInterface;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Exception\NotFoundException;
use Admin\App\Form\AbstractForm;
use Core\Admin\Entity\AdminRole;
use Dot\DependencyInjection\Attribute\Inject;
use Dot\FlashMessenger\FlashMessengerInterface;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Form\Exception\ExceptionInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function array_map;

/**
 * @phpstan-import-type SelectDataType from AbstractForm
 */
class GetEditAdminFormHandler implements RequestHandlerInterface
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

    /**
     * @throws ExceptionInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $admin = $this->adminService->findAdmin($request->getAttribute('id'));
        } catch (NotFoundException $exception) {
            $this->messenger->addError($exception->getMessage());

            return new EmptyResponse(StatusCodeInterface::STATUS_NOT_FOUND);
        }

        /** @var AdminRole[] $adminRoles */
        $adminRoles = $this->adminRoleService->getAdminRoleRepository()->findAll();
        $adminRoles = array_map(
        /** @return SelectDataType */
            fn (AdminRole $adminRole): array => [
                'label'    => $adminRole->getName()->value,
                'value'    => $adminRole->getId()->toString(),
                'selected' => $admin->hasRole($adminRole),
            ],
            $adminRoles
        );

        $this->editAdminForm->setAttribute(
            'action',
            $this->router->generateUri('admin::edit-admin', ['id' => $admin->getId()->toString()])
        );
        $this->editAdminForm->bind($admin)
            ->setRoles($adminRoles);

        return new HtmlResponse(
            $this->template->render('admin::edit-admin-form', [
                'form'  => $this->editAdminForm->prepare(),
                'admin' => $admin,
            ])
        );
    }
}
