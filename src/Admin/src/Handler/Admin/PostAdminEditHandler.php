<?php

declare(strict_types=1);

namespace Admin\Admin\Handler\Admin;

use Admin\Admin\Form\EditAdminForm;
use Admin\Admin\InputFilter\CreateAdminInputFilter;
use Admin\Admin\Service\AdminRoleServiceInterface;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Exception\BadRequestException;
use Admin\App\Exception\ConflictException;
use Admin\App\Exception\NotFoundException;
use Admin\App\Form\AbstractForm;
use Core\Admin\Entity\AdminRole;
use Core\App\Message;
use Dot\DependencyInjection\Attribute\Inject;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Log\Logger;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

use function array_map;

/**
 * @phpstan-import-type CreateAdminDataType from CreateAdminInputFilter
 * @phpstan-import-type SelectDataType from AbstractForm
 */
class PostAdminEditHandler implements RequestHandlerInterface
{
    #[Inject(
        AdminServiceInterface::class,
        AdminRoleServiceInterface::class,
        RouterInterface::class,
        TemplateRendererInterface::class,
        FlashMessengerInterface::class,
        EditAdminForm::class,
        'dot-log.default_logger',
    )]
    public function __construct(
        protected AdminServiceInterface $adminService,
        protected AdminRoleServiceInterface $adminRoleService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected FlashMessengerInterface $messenger,
        protected EditAdminForm $editAdminForm,
        protected Logger $logger,
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

        /** @var AdminRole[] $adminRoles */
        $adminRoles = $this->adminRoleService->getAdminRoleRepository()->findAll();
        $adminRoles = array_map(
            /** @return SelectDataType */
            fn (AdminRole $adminRole): array => [
                'label'    => $adminRole->getName()->value,
                'value'    => $adminRole->getUuid()->toString(),
                'selected' => $admin->hasRole($adminRole),
            ],
            $adminRoles
        );

        $this->editAdminForm
            ->setAttribute(
                'action',
                $this->router->generateUri('admin::edit-admin', ['uuid' => $admin->getUuid()->toString()])
            )
            ->setRoles($adminRoles);

        try {
            /** @var iterable<array<string, string|string[]>> $data */
            $data = $request->getParsedBody();
            $this->editAdminForm->setData($data);
            if ($this->editAdminForm->isValid()) {
                /** @var CreateAdminDataType $data */
                $data = $this->editAdminForm->getData();
                $this->adminService->saveAdmin($data, $admin);
                $this->messenger->addSuccess(Message::ADMIN_UPDATED);

                return new EmptyResponse(StatusCodeInterface::STATUS_CREATED);
            }

            return new HtmlResponse(
                $this->template->render('admin::edit-admin-form', [
                    'form'  => $this->editAdminForm->prepare(),
                    'admin' => $admin,
                ]),
                StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
            );
        } catch (BadRequestException | ConflictException | NotFoundException $exception) {
            return new HtmlResponse(
                $this->template->render('admin::edit-admin-form', [
                    'form'     => $this->editAdminForm->prepare(),
                    'admin'    => $admin,
                    'messages' => [
                        'error' => $exception->getMessage(),
                    ],
                ]),
                StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
            );
        } catch (Throwable $exception) {
            $this->logger->err('Update admin', [
                'error' => $exception->getMessage(),
                'file'  => $exception->getFile(),
                'line'  => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ]);
            $this->messenger->addError(Message::AN_ERROR_OCCURRED);

            return new EmptyResponse(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }
}
