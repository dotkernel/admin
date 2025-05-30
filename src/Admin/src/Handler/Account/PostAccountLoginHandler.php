<?php

declare(strict_types=1);

namespace Admin\Admin\Handler\Account;

use Admin\Admin\Adapter\AuthenticationAdapter;
use Admin\Admin\Form\LoginForm;
use Admin\Admin\Service\AdminLoginServiceInterface;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Plugin\FormsPlugin;
use Core\Admin\Entity\AdminIdentity;
use Core\App\Message;
use Core\App\Service\AuthenticationServiceInterface;
use Dot\DependencyInjection\Attribute\Inject;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Log\Logger;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface as LaminasAuthenticationServiceInterface;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Router\RouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

use function assert;

class PostAccountLoginHandler implements RequestHandlerInterface
{
    #[Inject(
        AdminServiceInterface::class,
        AdminLoginServiceInterface::class,
        RouterInterface::class,
        LaminasAuthenticationServiceInterface::class,
        FlashMessengerInterface::class,
        FormsPlugin::class,
        LoginForm::class,
        'dot-log.default_logger',
    )]
    public function __construct(
        protected AdminServiceInterface $adminService,
        protected AdminLoginServiceInterface $adminLoginService,
        protected RouterInterface $router,
        protected LaminasAuthenticationServiceInterface $authenticationService,
        protected FlashMessengerInterface $messenger,
        protected FormsPlugin $forms,
        protected LoginForm $loginForm,
        protected Logger $logger,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        assert($this->authenticationService instanceof AuthenticationServiceInterface);
        if ($this->authenticationService->hasIdentity()) {
            return new RedirectResponse($this->router->generateUri('app::index-redirect'));
        }

        try {
            $shouldRebind = $this->messenger->getData('shouldRebind') ?? true;
            if ($shouldRebind) {
                $this->forms->restoreState($this->loginForm);
            }

            /** @var iterable<array<string, string|string[]>> $data */
            $data = $request->getParsedBody();
            $this->loginForm->setData($data);

            if (! $this->loginForm->isValid()) {
                $this->messenger->addData('shouldRebind', true);
                $this->forms->saveState($this->loginForm);
                $this->messenger->addError($this->forms->getMessages($this->loginForm));
                return new RedirectResponse($request->getUri(), StatusCodeInterface::STATUS_SEE_OTHER);
            }

            /** @var non-empty-array<non-empty-string, non-empty-string> $data */
            $data = $this->loginForm->getData();

            /** @var non-empty-array<non-empty-string, mixed> $serverParams */
            $serverParams = $request->getServerParams();

            /** @var AuthenticationAdapter $adapter */
            $adapter = $this->authenticationService->getAdapter();
            $adapter->setIdentity($data['identity']);
            $adapter->setCredential($data['password']);
            $authResult = $this->authenticationService->authenticate();
            if (! $authResult->isValid()) {
                $this->adminLoginService->logFailedLogin($serverParams, $data['identity']);
                $this->messenger->addData('shouldRebind', true);
                $this->forms->saveState($this->loginForm);
                $this->messenger->addError($authResult->getMessages());

                return new RedirectResponse($request->getUri(), StatusCodeInterface::STATUS_SEE_OTHER);
            }

            /** @var AdminIdentity $identity */
            $identity = $authResult->getIdentity();
            if (! $identity->isActive()) {
                $this->authenticationService->clearIdentity();
                $this->messenger->addError(Message::ADMIN_INACTIVE);
                $this->messenger->addData('shouldRebind', true);
                $this->forms->saveState($this->loginForm);

                return new RedirectResponse($request->getUri(), StatusCodeInterface::STATUS_SEE_OTHER);
            }

            $this->adminLoginService->logSuccessfulLogin($serverParams, $data['identity']);
            $this->authenticationService->getStorage()->write($identity);

            return new RedirectResponse($this->router->generateUri('app::index-redirect'));
        } catch (Throwable $exception) {
            $this->messenger->addData('shouldRebind', true);
            $this->forms->saveState($this->loginForm);
            $this->messenger->addError(Message::AN_ERROR_OCCURRED);
            $this->logger->err('Login failed', [
                'error' => $exception->getMessage(),
                'file'  => $exception->getFile(),
                'line'  => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ]);

            return new RedirectResponse($request->getUri(), StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }
}
