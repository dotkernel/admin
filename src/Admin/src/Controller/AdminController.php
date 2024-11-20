<?php

declare(strict_types=1);

namespace Admin\Admin\Controller;

use Admin\Admin\Adapter\AuthenticationAdapter;
use Admin\Admin\Entity\Admin;
use Admin\Admin\Entity\AdminIdentity;
use Admin\Admin\Entity\AdminLogin;
use Admin\Admin\Form\AccountForm;
use Admin\Admin\Form\AdminDeleteForm;
use Admin\Admin\Form\AdminForm;
use Admin\Admin\Form\ChangePasswordForm;
use Admin\Admin\Form\LoginForm;
use Admin\Admin\FormData\AdminFormData;
use Admin\Admin\InputFilter\EditAdminInputFilter;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Common\ServerRequestAwareTrait;
use Admin\App\Exception\IdentityException;
use Admin\App\Message;
use Admin\App\Pagination;
use Admin\App\Plugin\FormsPlugin;
use Admin\Setting\Entity\Setting;
use Admin\Setting\Service\SettingService;
use Doctrine\ORM\NonUniqueResultException;
use Dot\Controller\AbstractActionController;
use Dot\DependencyInjection\Attribute\Inject;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Log\Logger;
use Fig\Http\Message\RequestMethodInterface;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Authentication\Exception\ExceptionInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use MaxMind\Db\Reader\InvalidDatabaseException;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

use function assert;

class AdminController extends AbstractActionController
{
    use ServerRequestAwareTrait;

    #[Inject(
        AdminServiceInterface::class,
        RouterInterface::class,
        TemplateRendererInterface::class,
        AuthenticationServiceInterface::class,
        FlashMessengerInterface::class,
        FormsPlugin::class,
        AdminForm::class,
        SettingService::class,
        "dot-log.default_logger",
    )]
    public function __construct(
        protected AdminServiceInterface $adminService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected AuthenticationServiceInterface $authenticationService,
        protected FlashMessengerInterface $messenger,
        protected FormsPlugin $forms,
        protected AdminForm $adminForm,
        protected SettingService $settingService,
        protected Logger $logger,
    ) {
    }

    public function addAction(): ResponseInterface
    {
        if ($this->isPost()) {
            $this->adminForm->setData($this->getPostParams());
            if ($this->adminForm->isValid()) {
                /** @var array $result */
                $result = $this->adminForm->getData();
                try {
                    $this->adminService->createAdmin($result);
                    return new JsonResponse(['message' => Message::ADMIN_CREATED_SUCCESSFULLY]);
                } catch (IdentityException $e) {
                    $this->logErrors($e, Message::CREATE_ADMIN);
                    return new JsonResponse(
                        ['message' => $e->getMessage()],
                        StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
                    );
                } catch (Throwable $e) {
                    $this->logErrors($e, Message::CREATE_ADMIN);
                    return new JsonResponse(
                        ['message' => Message::AN_ERROR_OCCURRED],
                        StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR
                    );
                }
            } else {
                return new JsonResponse(
                    ['message' => $this->forms->getMessagesAsString($this->adminForm)],
                    StatusCodeInterface::STATUS_BAD_REQUEST
                );
            }
        }

        return new JsonResponse([
            'data' => $this->template->render(
                'partial::ajax-form',
                [
                    'form'       => $this->adminForm,
                    'formAction' => '/admin/add',
                    'method'     => RequestMethodInterface::METHOD_POST,
                ]
            ),
        ]);
    }

    public function editAction(): ResponseInterface
    {
        $uuid = $this->getAttribute('uuid');

        /** @var Admin $admin */
        $admin = $this->adminService->getAdminRepository()->findOneBy(['uuid' => $uuid]);

        $adminFormData = (new AdminFormData())->fromEntity($admin);

        if ($this->isPost()) {
            $this->adminForm->setData($this->getPostParams());
            $this->adminForm->setInputFilter(new EditAdminInputFilter());
            if ($this->adminForm->isValid()) {
                /** @var array $result */
                $result = $this->adminForm->getData();
                try {
                    $this->adminService->updateAdmin($admin, $result);
                    return new JsonResponse(['message' => Message::ADMIN_UPDATED_SUCCESSFULLY]);
                } catch (IdentityException $e) {
                    $this->logErrors($e, Message::UPDATE_ADMIN);
                    return new JsonResponse(
                        ['message' => $e->getMessage()],
                        StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
                    );
                } catch (Throwable $e) {
                    $this->logErrors($e, Message::UPDATE_ADMIN);
                    return new JsonResponse(
                        ['message' => Message::AN_ERROR_OCCURRED],
                        StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR
                    );
                }
            } else {
                return new JsonResponse(
                    ['message' => $this->forms->getMessagesAsString($this->adminForm)],
                    StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR
                );
            }
        }

        $this->adminForm->bind($adminFormData);

        return new JsonResponse([
            'data' => $this->template->render(
                'partial::ajax-form',
                [
                    'form'       => $this->adminForm,
                    'formAction' => '/admin/edit/' . $uuid,
                    'method'     => RequestMethodInterface::METHOD_POST,
                ]
            ),
        ]);
    }

    public function deleteAction(): ResponseInterface
    {
        $uuid = $this->getAttribute('uuid');
        if (empty($uuid)) {
            return new JsonResponse(
                ['message' => Message::ADMIN_NOT_FOUND],
                StatusCodeInterface::STATUS_NOT_FOUND
            );
        }
        $admin = $this->adminService->getAdminRepository()->findOneBy(['uuid' => $uuid]);
        assert($admin instanceof Admin);

        $form = new AdminDeleteForm();
        $form->setAttribute(
            'action',
            $this->router->generateUri('admin', ['action' => 'delete', 'uuid' => $uuid])
        );

        if ($this->isPost()) {
            $form->setData($this->getPostParams());
            if (! $form->isValid()) {
                return new JsonResponse(
                    ['message' => $this->forms->getMessages($form)],
                    StatusCodeInterface::STATUS_BAD_REQUEST
                );
            }

            try {
                $this->adminService->getAdminRepository()->deleteAdmin($admin);
                return new JsonResponse(['message' => Message::ADMIN_DELETED_SUCCESSFULLY]);
            } catch (Throwable $e) {
                $this->logErrors($e, Message::DELETE_ADMIN);
                return new JsonResponse(
                    ['message' => Message::AN_ERROR_OCCURRED],
                    StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR
                );
            }
        }

        return new JsonResponse([
            'data' => $this->template->render(
                'admin::delete',
                [
                    'admin' => $admin,
                    'form'  => $form->prepare(),
                ]
            ),
        ]);
    }

    public function listAction(): ResponseInterface
    {
        $result = $this->adminService->getAdmins(
            $this->getQueryParam('offset', 0, 'int'),
            $this->getQueryParam('limit', 30, 'int'),
            $this->getQueryParam('search'),
            $this->getQueryParam('sort', 'created'),
            $this->getQueryParam('order', 'desc')
        );

        return new JsonResponse($result);
    }

    public function manageAction(): ResponseInterface
    {
        return new HtmlResponse(
            $this->template->render('admin::list')
        );
    }

    /**
     * @throws ExceptionInterface
     * @throws InvalidDatabaseException
     */
    public function loginAction(): ResponseInterface
    {
        if ($this->authenticationService->hasIdentity()) {
            return new RedirectResponse($this->router->generateUri("dashboard"));
        }

        $form         = new LoginForm();
        $shouldRebind = $this->messenger->getData('shouldRebind') ?? true;
        if ($shouldRebind) {
            $this->forms->restoreState($form);
        }

        if ($this->isPost()) {
            $form->setData($this->getRequest()->getParsedBody());
            if ($form->isValid()) {
                /** @var AuthenticationAdapter $adapter */
                $adapter = $this->authenticationService->getAdapter();

                /** @var array $data */
                $data = $form->getData();
                $adapter->setIdentity($data['username']);
                $adapter->setCredential($data['password']);
                $authResult = $this->authenticationService->authenticate();
                if ($authResult->isValid()) {
                    $identity = $authResult->getIdentity();
                    $this->adminService->logAdminVisit(
                        $this->getServerParams(),
                        $data['username'],
                        AdminLogin::LOGIN_SUCCESS
                    );
                    if ($identity->getStatus() === Admin::STATUS_INACTIVE) {
                        $this->authenticationService->clearIdentity();
                        $this->messenger->addError('Admin is inactive', 'user-login');
                        $this->messenger->addData('shouldRebind', true);
                        $this->forms->saveState($form);
                        return new RedirectResponse($this->getRequest()->getUri(), 303);
                    }
                    $this->authenticationService->getStorage()->write($identity);

                    return new RedirectResponse($this->router->generateUri('dashboard'));
                } else {
                    $this->adminService->logAdminVisit(
                        $this->getServerParams(),
                        $data['username'],
                        AdminLogin::LOGIN_FAIL
                    );
                    $this->messenger->addData('shouldRebind', true);
                    $this->forms->saveState($form);
                    $this->messenger->addError($authResult->getMessages(), 'user-login');
                    return new RedirectResponse($this->getRequest()->getUri(), 303);
                }
            } else {
                $this->messenger->addData('shouldRebind', true);
                $this->forms->saveState($form);
                $this->messenger->addError($this->forms->getMessages($form), 'user-login');
                return new RedirectResponse($this->getRequest()->getUri(), 303);
            }
        }

        return new HtmlResponse(
            $this->template->render('admin::login', [
                'form' => $form->prepare(),
            ])
        );
    }

    public function logoutAction(): ResponseInterface
    {
        $this->authenticationService->clearIdentity();

        return new RedirectResponse(
            $this->router->generateUri('admin', ['action' => 'login'])
        );
    }

    public function accountAction(): ResponseInterface
    {
        $accountForm        = new AccountForm();
        $changePasswordForm = new ChangePasswordForm();
        $changePasswordForm
            ->setAttribute('action', $this->router->generateUri('admin', ['action' => 'change-password']));

        $identity = $this->authenticationService->getIdentity();
        $admin    = $this->adminService->getAdminRepository()->findOneBy(['uuid' => $identity->getUuid()]);

        if ($this->isPost()) {
            $accountForm->setData($this->getPostParams());
            if ($accountForm->isValid()) {
                /** @var array $result */
                $result = $accountForm->getData();
                try {
                    $this->adminService->updateAdmin($admin, $result);
                    $this->messenger->addSuccess(Message::ACCOUNT_UPDATE_SUCCESSFULLY);
                } catch (IdentityException $e) {
                    $this->logErrors($e, Message::UPDATE_ADMIN);
                    $this->messenger->addError($e->getMessage());
                } catch (Throwable $e) {
                    $this->logErrors($e, Message::UPDATE_ADMIN);
                    $this->messenger->addError(Message::AN_ERROR_OCCURRED);
                }
            } else {
                $this->messenger->addError($this->forms->getMessagesAsString($accountForm));
            }
            return new RedirectResponse($this->router->generateUri('admin', ['action' => 'account']));
        }

        $accountForm->bind($admin);

        return new HtmlResponse(
            $this->template->render('admin::account', [
                'accountForm'        => $accountForm->prepare(),
                'changePasswordForm' => $changePasswordForm->prepare(),
            ])
        );
    }

    public function changePasswordAction(): ResponseInterface
    {
        $changePasswordForm = new ChangePasswordForm();
        /** @var AdminIdentity $adminIdentity */
        $adminIdentity = $this->authenticationService->getIdentity();
        $admin         = $this->adminService->getAdminRepository()->findOneBy([
            'identity' => $adminIdentity->getIdentity(),
        ]);

        if ($this->isPost()) {
            $changePasswordForm->setData($this->getPostParams());
            if ($changePasswordForm->isValid()) {
                /** @var array $result */
                $result = $changePasswordForm->getData();
                if ($admin->verifyPassword($result['currentPassword'])) {
                    try {
                        $this->adminService->updateAdmin($admin, $result);
                        $this->messenger->addSuccess(Message::ACCOUNT_UPDATE_SUCCESSFULLY);
                    } catch (IdentityException $e) {
                        $this->logErrors($e, Message::CHANGE_PASSWORD);
                        $this->messenger->addError($e->getMessage());
                    } catch (Throwable $e) {
                        $this->logErrors($e, Message::CHANGE_PASSWORD);
                        $this->messenger->addError(Message::AN_ERROR_OCCURRED);
                    }
                } else {
                    $this->messenger->addError(Message::CURRENT_PASSWORD_INCORRECT);
                }
            } else {
                $this->messenger->addError($this->forms->getMessagesAsString($changePasswordForm));
            }
        }

        return new RedirectResponse($this->router->generateUri('admin', ['action' => 'account']));
    }

    public function loginsAction(): ResponseInterface
    {
        return new HtmlResponse(
            $this->template->render('admin::list-logins')
        );
    }

    /**
     * @throws NonUniqueResultException
     */
    public function listLoginsAction(): ResponseInterface
    {
        $result = $this->adminService->getAdminLogins(
            $this->getQueryParam('offset', 0, 'int'),
            $this->getQueryParam('limit', 30, 'int'),
            $this->getQueryParam('sort', 'created'),
            $this->getQueryParam('order', 'desc')
        );

        return new JsonResponse($result);
    }

    public function simpleLoginsAction(): ResponseInterface
    {
        $params = [
            'offset'   => $this->getQueryParam('offset', 0, 'int'),
            'limit'    => $this->getQueryParam('limit', 10, 'int'),
            'sort'     => $this->getQueryParam('sort', 'created'),
            'order'    => $this->getQueryParam('order', 'desc'),
            'identity' => $this->getQueryParam('identity'),
            'status'   => $this->getQueryParam('status'),
        ];

        $logins = $this->adminService->getAdminLogins(
            $params['offset'],
            $params['limit'],
            $params['sort'],
            $params['order'],
            [
                'identity' => $params['identity'],
                'status'   => $params['status'],
            ]
        );

        $settings = $this->settingService->findOneBy([
            'admin'      => $this->adminService->getAdminRepository()->findOneBy([
                'identity' => $this->authenticationService->getIdentity()->getIdentity(),
            ]),
            'identifier' => Setting::IDENTIFIER_TABLE_ADMIN_LIST_LOGINS_SELECTED_COLUMNS,
        ]);

        return new HtmlResponse(
            $this->template->render('admin::simple-logins', [
                'params'     => $params,
                'logins'     => $logins['rows'],
                'settings'   => $settings?->getValue() ?? [],
                'statuses'   => [AdminLogin::LOGIN_FAIL, AdminLogin::LOGIN_SUCCESS],
                'identities' => $this->adminService->getAdminLoginIdentities(),
                'identifier' => Setting::IDENTIFIER_TABLE_ADMIN_LIST_LOGINS_SELECTED_COLUMNS,
                'pagination' => new Pagination($logins['total'], $params['offset'], $params['limit']),
            ])
        );
    }

    private function logErrors(Throwable $e, string $message): void
    {
        $this->logger->err($message, [
            'error' => $e->getMessage(),
            'file'  => $e->getFile(),
            'line'  => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);
    }
}
