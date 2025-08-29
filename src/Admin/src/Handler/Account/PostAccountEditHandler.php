<?php

declare(strict_types=1);

namespace Admin\Admin\Handler\Account;

use Admin\Admin\Form\AccountForm;
use Admin\Admin\Form\ChangePasswordForm;
use Admin\Admin\InputFilter\EditAccountInputFilter;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Exception\BadRequestException;
use Admin\App\Exception\ConflictException;
use Admin\App\Exception\NotFoundException;
use Core\App\Message;
use Dot\DependencyInjection\Attribute\Inject;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Log\Logger;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

/**
 * @phpstan-import-type EditAccountDataType from EditAccountInputFilter
 */
class PostAccountEditHandler implements RequestHandlerInterface
{
    #[Inject(
        AdminServiceInterface::class,
        RouterInterface::class,
        TemplateRendererInterface::class,
        AuthenticationServiceInterface::class,
        AccountForm::class,
        ChangePasswordForm::class,
        FlashMessengerInterface::class,
        'dot-log.default_logger',
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
        /** @var iterable<array<string, string|string[]>> $data */
        $data = $request->getParsedBody();
        $this->accountForm->setData($data);
        if (! $this->accountForm->isValid()) {
            return new HtmlResponse(
                $this->template->render('admin::view-account', [
                    'accountForm'        => $this->accountForm->prepare(),
                    'changePasswordForm' => $this->changePasswordForm->prepare(),
                ])
            );
        }

        try {
            $admin = $this->adminService->findAdmin($this->authenticationService->getIdentity()->getUuid());
        } catch (NotFoundException $exception) {
            $this->messenger->addError($exception->getMessage());

            return new EmptyResponse(StatusCodeInterface::STATUS_NOT_FOUND);
        }

        $this->accountForm->setAttribute('action', $this->router->generateUri('admin::edit-account'));
        $this->changePasswordForm
            ->setAttribute('action', $this->router->generateUri('admin::change-account-password'));

        try {
            /** @var EditAccountDataType $data */
            $data = $this->accountForm->getData();
            $this->adminService->saveAdmin($data, $admin);
            $this->messenger->addSuccess(Message::ACCOUNT_UPDATED);
        } catch (BadRequestException | ConflictException | NotFoundException $exception) {
            $this->messenger->addError($exception->getMessage());
        } catch (Throwable $exception) {
            $this->logger->err('Update admin', [
                'error' => $exception->getMessage(),
                'file'  => $exception->getFile(),
                'line'  => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ]);
            $this->messenger->addError(Message::AN_ERROR_OCCURRED);
        }

        return new RedirectResponse($this->router->generateUri('admin::edit-account'));
    }
}
