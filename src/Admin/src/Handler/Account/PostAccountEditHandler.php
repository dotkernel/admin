<?php

declare(strict_types=1);

namespace Admin\Admin\Handler\Account;

use Admin\Admin\Form\AccountForm;
use Admin\Admin\Form\ChangePasswordForm;
use Admin\App\Message;
use Core\Admin\Service\AdminServiceInterface;
use Core\App\Common\ServerRequestAwareTrait;
use Core\App\Exception\IdentityException;
use Dot\DependencyInjection\Attribute\Inject;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Log\Logger;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class PostAccountEditHandler implements RequestHandlerInterface
{
    use ServerRequestAwareTrait;

    #[Inject(
        AdminServiceInterface::class,
        RouterInterface::class,
        TemplateRendererInterface::class,
        AuthenticationServiceInterface::class,
        AccountForm::class,
        ChangePasswordForm::class,
        FlashMessengerInterface::class,
        "dot-log.default_logger",
    )]
    public function __construct(
        protected AdminServiceInterface $adminService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected AuthenticationServiceInterface $authenticationService,
        protected AccountForm $accountForm,
        protected ChangePasswordForm $changePasswordForm,
        protected FlashMessengerInterface $messenger,
        protected Logger $logger,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->accountForm->setAttribute('action', $this->router->generateUri('admin::edit-account'));

        $this->changePasswordForm->setAttribute(
            'action',
            $this->router->generateUri('admin::account-change-password')
        );

        $identity = $this->authenticationService->getIdentity();
        $admin    = $this->adminService->getAdminRepository()->findOneBy(['uuid' => $identity->getUuid()]);

        $this->accountForm->setData($this->getPostParams($request));
        if (! $this->accountForm->isValid()) {
            return new HtmlResponse(
                $this->template->render('admin::account', [
                    'accountForm'        => $this->accountForm->prepare(),
                    'changePasswordForm' => $this->changePasswordForm->prepare(),
                ])
            );
        }

        try {
            /** @var array $result */
            $result = $this->accountForm->getData();

            $this->adminService->updateAdmin($admin, $result);
            $this->messenger->addSuccess(Message::ACCOUNT_UPDATE_SUCCESSFULLY);
        } catch (IdentityException $e) {
            $this->messenger->addError($e->getMessage());
        } catch (Throwable $e) {
            $this->logger->err(Message::UPDATE_ADMIN, [
                'error' => $e->getMessage(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->messenger->addError(Message::AN_ERROR_OCCURRED);
        }

        return new RedirectResponse($this->router->generateUri('admin::edit-account'));
    }
}
