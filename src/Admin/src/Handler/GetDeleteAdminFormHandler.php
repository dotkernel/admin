<?php

declare(strict_types=1);

namespace Admin\Admin\Handler;

use Admin\Admin\Entity\Admin;
use Admin\Admin\Form\AdminDeleteForm;
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

class GetDeleteAdminFormHandler implements RequestHandlerInterface
{
    #[Inject(
        AdminServiceInterface::class,
        RouterInterface::class,
        TemplateRendererInterface::class,
        FlashMessengerInterface::class,
        AdminDeleteForm::class,
    )]
    public function __construct(
        protected AdminServiceInterface $adminService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected FlashMessengerInterface $messenger,
        protected AdminDeleteForm $form,
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
            $this->router->generateUri('admin::delete-admin', [
                'uuid' => $admin->getUuid()->toString(),
            ])
        );

        return new HtmlResponse(
            $this->template->render('admin::delete-admin-modal-content', [
                'form'  => $this->form,
                'admin' => $admin,
            ]),
        );
    }
}
