<?php

declare(strict_types=1);

namespace Admin\Admin\Handler\Account;

use Admin\Admin\Entity\AdminIdentity;
use Admin\Admin\Form\AccountForm;
use Admin\Admin\Form\ChangePasswordForm;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Common\ServerRequestAwareTrait;
use Admin\App\Exception\IdentityException;
use Admin\App\Message;
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

class ChangePasswordHandler implements RequestHandlerInterface
{
    use ServerRequestAwareTrait;

    #[Inject(
        AdminServiceInterface::class,
        RouterInterface::class,
        TemplateRendererInterface::class,
        AuthenticationServiceInterface::class,
        FlashMessengerInterface::class,
        AccountForm::class,
        ChangePasswordForm::class,
        "dot-log.default_logger",
    )]
    public function __construct(
        protected AdminServiceInterface $adminService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected AuthenticationServiceInterface $authenticationService,
        protected FlashMessengerInterface $messenger,
        protected AccountForm $accountForm,
        protected ChangePasswordForm $changePasswordForm,
        protected Logger $logger,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->accountForm->setAttribute('action', $this->router->generateUri('admin::edit-account'));
        $this->changePasswordForm->setAttribute('action', $this->router->generateUri('admin::change-password'));

        /** @var AdminIdentity $adminIdentity */
        $adminIdentity = $this->authenticationService->getIdentity();
        $admin         = $this->adminService->getAdminRepository()->findOneBy([
            'identity' => $adminIdentity->getIdentity(),
        ]);

        $this->changePasswordForm->setData($this->getPostParams($request));
        if (! $this->changePasswordForm->isValid()) {
            return new HtmlResponse(
                $this->template->render('admin::account', [
                    'accountForm'        => $this->accountForm->prepare(),
                    'changePasswordForm' => $this->changePasswordForm->prepare(),
                ])
            );
        }

        try {
            /** @var array $result */
            $result = $this->changePasswordForm->getData();
            if ($admin->verifyPassword($result['currentPassword'])) {
                $this->adminService->updateAdmin($admin, $result);
                $this->messenger->addSuccess(Message::ACCOUNT_UPDATE_SUCCESSFULLY);
            } else {
                $this->messenger->addError(Message::CURRENT_PASSWORD_INCORRECT);
            }
        } catch (IdentityException $e) {
            $this->messenger->addError($e->getMessage());
        } catch (Throwable $e) {
            $this->logger->err(Message::CHANGE_PASSWORD, [
                'error' => $e->getMessage(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->messenger->addError(Message::AN_ERROR_OCCURRED);
        }

        return new RedirectResponse($this->router->generateUri('admin::account-form'));
    }
}
