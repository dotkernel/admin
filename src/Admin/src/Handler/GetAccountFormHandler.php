<?php

declare(strict_types=1);

namespace Admin\Admin\Handler;

use Admin\Admin\Form\AccountForm;
use Admin\Admin\Form\ChangePasswordForm;
use Admin\Admin\Service\AdminServiceInterface;
use Dot\DependencyInjection\Attribute\Inject;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetAccountFormHandler implements RequestHandlerInterface
{
    #[Inject(
        AdminServiceInterface::class,
        RouterInterface::class,
        TemplateRendererInterface::class,
        AuthenticationServiceInterface::class,
        AccountForm::class,
        ChangePasswordForm::class,
    )]
    public function __construct(
        protected AdminServiceInterface $adminService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected AuthenticationServiceInterface $authenticationService,
        protected AccountForm $accountForm,
        protected ChangePasswordForm $changePasswordForm,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->accountForm->setAttribute('action', $this->router->generateUri('admin::edit-account'));
        $this->changePasswordForm->setAttribute(
            'action',
            $this->router->generateUri('admin::change-password')
        );

        $identity = $this->authenticationService->getIdentity();
        $admin    = $this->adminService->getAdminRepository()->findOneBy(['uuid' => $identity->getUuid()]);

        $this->accountForm->bind($admin);

        return new HtmlResponse(
            $this->template->render('admin::account', [
                'accountForm'        => $this->accountForm->prepare(),
                'changePasswordForm' => $this->changePasswordForm->prepare(),
            ])
        );
    }
}
