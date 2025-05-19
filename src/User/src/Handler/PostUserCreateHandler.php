<?php

declare(strict_types=1);

namespace Admin\User\Handler;

use Admin\App\Exception\BadRequestException;
use Admin\App\Exception\ConflictException;
use Admin\App\Exception\NotFoundException;
use Admin\User\Form\CreateUserForm;
use Admin\User\Service\UserServiceInterface;
use Core\App\Message;
use Core\App\Service\MailService;
use Dot\DependencyInjection\Attribute\Inject;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Log\Logger;
use Dot\Mail\Exception\MailException;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class PostUserCreateHandler implements RequestHandlerInterface
{
    /**
     * @param array<non-empty-string, mixed> $config
     */
    #[Inject(
        UserServiceInterface::class,
        RouterInterface::class,
        TemplateRendererInterface::class,
        FlashMessengerInterface::class,
        CreateUserForm::class,
        MailService::class,
        'dot-log.default_logger',
        'config',
    )]
    public function __construct(
        protected UserServiceInterface $userService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected FlashMessengerInterface $messenger,
        protected CreateUserForm $createUserForm,
        protected MailService $mailService,
        protected Logger $logger,
        protected array $config,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->createUserForm->setAttribute('action', $this->router->generateUri('user::user-create'));

        $user = null;
        try {
            $this->createUserForm->setData($request->getParsedBody());
            if ($this->createUserForm->isValid()) {
                $user = $this->userService->saveUser((array) $this->createUserForm->getData());
                $this->messenger->addSuccess(Message::USER_CREATED);
                if ($user->getDetail()->hasEmail()) {
                    $body = $this->template->render('user::welcome', [
                        'config' => $this->config,
                        'user'   => $user,
                    ]);
                    $this->mailService->sendWelcomeMail($user, $body);
                }

                return new EmptyResponse(StatusCodeInterface::STATUS_CREATED);
            }

            return new HtmlResponse(
                $this->template->render('user::user-create-form', [
                    'form' => $this->createUserForm->prepare(),
                ]),
                StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
            );
        } catch (MailException $exception) {
            $this->logger->err('Send user welcome email', [
                'error' => $exception->getMessage(),
                'file'  => $exception->getFile(),
                'line'  => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ]);
            $this->messenger->addError(Message::mailNotSentTo($user->getDetail()->getEmail()));
            return new EmptyResponse(StatusCodeInterface::STATUS_CREATED);
        } catch (BadRequestException | ConflictException | NotFoundException $exception) {
            return new HtmlResponse(
                $this->template->render('user::user-create-form', [
                    'form'     => $this->createUserForm->prepare(),
                    'messages' => [
                        'error' => $exception->getMessage(),
                    ],
                ]),
                StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
            );
        } catch (Throwable $exception) {
            $this->logger->err('Create user', [
                'error' => $exception->getMessage(),
                'file'  => $exception->getFile(),
                'line'  => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ]);

            return new HtmlResponse(
                $this->template->render('user::user-create-form', [
                    'form'     => $this->createUserForm->prepare(),
                    'messages' => [
                        'error' => Message::AN_ERROR_OCCURRED,
                    ],
                ]),
                StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR
            );
        }
    }
}
