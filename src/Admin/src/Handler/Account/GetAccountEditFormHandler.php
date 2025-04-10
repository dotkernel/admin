<?php

declare(strict_types=1);

namespace Admin\Admin\Handler\Account;

use Admin\Admin\Form\AccountForm;
use Admin\Admin\Form\ChangePasswordForm;
use Admin\Admin\Service\AdminServiceInterface;
use Core\App\Exception\NotFoundException;
use Dot\DependencyInjection\Attribute\Inject;
use Dot\FlashMessenger\FlashMessengerInterface;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetAccountEditFormHandler implements RequestHandlerInterface
{
    #[Inject(
        AdminServiceInterface::class,
        RouterInterface::class,
        TemplateRendererInterface::class,
        AuthenticationServiceInterface::class,
        AccountForm::class,
        ChangePasswordForm::class,
        FlashMessengerInterface::class,
    )]
    public function __construct(
        protected AdminServiceInterface $adminService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected AuthenticationServiceInterface $authenticationService,
        protected AccountForm $accountForm,
        protected ChangePasswordForm $changePasswordForm,
        protected FlashMessengerInterface $messenger,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $admin = $this->adminService->findAdmin($this->authenticationService->getIdentity()->getUuid());
        } catch (NotFoundException $exception) {
            $this->messenger->addError($exception->getMessage());

            return new EmptyResponse(StatusCodeInterface::STATUS_NOT_FOUND);
        }

        $this->accountForm->setAttribute('action', $this->router->generateUri('admin::account-edit'));
        $this->changePasswordForm
            ->setAttribute('action', $this->router->generateUri('admin::account-change-password'));

        $this->accountForm->bind($admin);

        return new HtmlResponse(
            $this->template->render('admin::account-view', [
                'accountForm'        => $this->accountForm->prepare(),
                'changePasswordForm' => $this->changePasswordForm->prepare(),
            ])
        );
    }
}
