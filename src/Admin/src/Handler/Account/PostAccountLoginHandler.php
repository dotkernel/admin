<?php

declare(strict_types=1);

namespace Admin\Admin\Handler\Account;

use Admin\Admin\Adapter\AuthenticationAdapter;
use Admin\Admin\Enum\AdminStatusEnum;
use Admin\Admin\Enum\SuccessFailureEnum;
use Admin\Admin\Form\LoginForm;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Common\ServerRequestAwareTrait;
use Admin\App\Message;
use Admin\App\Plugin\FormsPlugin;
use Dot\DependencyInjection\Attribute\Inject;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Log\Logger;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Router\RouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class PostAccountLoginHandler implements RequestHandlerInterface
{
    use ServerRequestAwareTrait;

    #[Inject(
        AdminServiceInterface::class,
        RouterInterface::class,
        AuthenticationServiceInterface::class,
        FlashMessengerInterface::class,
        FormsPlugin::class,
        LoginForm::class,
        "dot-log.default_logger",
    )]
    public function __construct(
        protected AdminServiceInterface $adminService,
        protected RouterInterface $router,
        protected AuthenticationServiceInterface $authenticationService,
        protected FlashMessengerInterface $messenger,
        protected FormsPlugin $forms,
        protected LoginForm $form,
        protected Logger $logger,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            if ($this->authenticationService->hasIdentity()) {
                return new RedirectResponse($this->router->generateUri('app::index-redirect'));
            }

            $shouldRebind = $this->messenger->getData('shouldRebind') ?? true;
            if ($shouldRebind) {
                $this->forms->restoreState($this->form);
            }

            $this->form->setData($this->getPostParams($request));

            if (! $this->form->isValid()) {
                $this->messenger->addData('shouldRebind', true);
                $this->forms->saveState($this->form);
                $this->messenger->addError($this->forms->getMessages($this->form));
                return new RedirectResponse($request->getUri(), StatusCodeInterface::STATUS_SEE_OTHER);
            }

            /** @var AuthenticationAdapter $adapter */
            $adapter = $this->authenticationService->getAdapter();

            /** @var array $data */
            $data = $this->form->getData();
            $adapter->setIdentity($data['username']);
            $adapter->setCredential($data['password']);
            $authResult = $this->authenticationService->authenticate();
            if (! $authResult->isValid()) {
                $this->adminService->logAdminVisit(
                    $this->getServerParams($request),
                    $data['username'],
                    SuccessFailureEnum::Fail,
                );

                $this->messenger->addData('shouldRebind', true);
                $this->forms->saveState($this->form);
                $this->messenger->addError($authResult->getMessages());

                return new RedirectResponse($request->getUri(), StatusCodeInterface::STATUS_SEE_OTHER);
            } else {
                $identity = $authResult->getIdentity();
                if ($identity->getStatus() === AdminStatusEnum::Inactive) {
                    $this->authenticationService->clearIdentity();
                    $this->messenger->addError(Message::ADMIN_INACTIVE);
                    $this->messenger->addData('shouldRebind', true);
                    $this->forms->saveState($this->form);
                    return new RedirectResponse($request->getUri(), StatusCodeInterface::STATUS_SEE_OTHER);
                }

                $this->adminService->logAdminVisit(
                    $this->getServerParams($request),
                    $data['username'],
                    SuccessFailureEnum::Success,
                );

                $this->authenticationService->getStorage()->write($identity);

                return new RedirectResponse($this->router->generateUri('app::index-redirect'));
            }
        } catch (Throwable $e) {
            $this->messenger->addData('shouldRebind', true);
            $this->forms->saveState($this->form);
            $this->messenger->addError(Message::AN_ERROR_OCCURRED);

            $this->logger->err(Message::LOGIN_FAILED, [
                'error' => $e->getMessage(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return new RedirectResponse($request->getUri(), StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }
}
