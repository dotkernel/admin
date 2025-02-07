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
use Dot\Controller\AbstractActionController;
use Dot\DependencyInjection\Attribute\Inject;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Log\Logger;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Authentication\Exception\ExceptionInterface;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use MaxMind\Db\Reader\InvalidDatabaseException;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

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
        try {
            $this->adminForm->setAttribute('action', $this->router->generateUri('admin', ['action' => 'add']));
            if (! $this->isPost()) {
                return new HtmlResponse(
                    $this->template->render('admin::add-admin-modal-content', [
                        'form' => $this->adminForm,
                    ])
                );
            }

            $this->adminForm->setData($this->getPostParams());
            if ($this->adminForm->isValid()) {
                /** @var array $result */
                $result = $this->adminForm->getData();
                $this->adminService->createAdmin($result);
                $this->messenger->addSuccess(Message::ADMIN_CREATED_SUCCESSFULLY);
                return new EmptyResponse(StatusCodeInterface::STATUS_CREATED);
            } else {
                return new HtmlResponse(
                    $this->template->render('admin::add-admin-modal-content', [
                        'form' => $this->adminForm,
                    ]),
                    StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
                );
            }
        } catch (IdentityException $e) {
            $this->logErrors($e, Message::CREATE_ADMIN);
            return new HtmlResponse(
                $this->template->render('admin::add-admin-modal-content', [
                    'form'     => $this->adminForm,
                    'messages' => [
                        'error' => $e->getMessage(),
                    ],
                ]),
                StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
            );
        } catch (Throwable $e) {
            $this->logErrors($e, Message::CREATE_ADMIN);
            return new HtmlResponse(
                $this->template->render('admin::add-admin-modal-content', [
                    'form'     => $this->adminForm,
                    'messages' => [
                        'error' => Message::AN_ERROR_OCCURRED,
                    ],
                ]),
                StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function editAction(): ResponseInterface
    {
        try {
            $admin = $this->adminService->getAdminRepository()->findOneBy(['uuid' => $this->getAttribute('uuid')]);
            if (! $admin instanceof Admin) {
                $this->messenger->addError(Message::ADMIN_NOT_FOUND);
                return new EmptyResponse(StatusCodeInterface::STATUS_NOT_FOUND);
            }

            $this->adminForm->setAttribute(
                'action',
                $this->router->generateUri('admin', ['action' => 'edit', 'uuid' => $admin->getUuid()->toString()])
            );

            if (! $this->isPost()) {
                $adminFormData = (new AdminFormData())->fromEntity($admin);
                $this->adminForm->bind($adminFormData);
                return new HtmlResponse(
                    $this->template->render('admin::edit-admin-modal-content', [
                        'form' => $this->adminForm,
                    ])
                );
            }

            $this->adminForm->setInputFilter(new EditAdminInputFilter());
            $this->adminForm->setData($this->getPostParams());
            if ($this->adminForm->isValid()) {
                /** @var array $result */
                $result = $this->adminForm->getData();
                $this->adminService->updateAdmin($admin, $result);

                $this->messenger->addSuccess(Message::ADMIN_UPDATED_SUCCESSFULLY);
                return new EmptyResponse(StatusCodeInterface::STATUS_CREATED);
            } else {
                return new HtmlResponse(
                    $this->template->render('admin::edit-admin-modal-content', [
                        'form' => $this->adminForm,
                    ]),
                    StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
                );
            }
        } catch (IdentityException $exception) {
            $this->logErrors($exception, Message::UPDATE_ADMIN);
            return new HtmlResponse(
                $this->template->render('admin::edit-admin-modal-content', [
                    'form'     => $this->adminForm,
                    'messages' => [
                        'error' => $exception->getMessage(),
                    ],
                ]),
                StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
            );
        } catch (Throwable $exception) {
            $this->logErrors($exception, Message::UPDATE_ADMIN);
            $this->messenger->addError(Message::AN_ERROR_OCCURRED);
            return new EmptyResponse(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteAction(): ResponseInterface
    {
        try {
            $admin = $this->adminService->getAdminRepository()->findOneBy(['uuid' => $this->getAttribute('uuid')]);
            if (! $admin instanceof Admin) {
                $this->messenger->addError(Message::ADMIN_NOT_FOUND);
                return new EmptyResponse(StatusCodeInterface::STATUS_NOT_FOUND);
            }

            $form = new AdminDeleteForm();
            $form->setAttribute(
                'action',
                $this->router->generateUri('admin', [
                    'action' => 'delete',
                    'uuid'   => $admin->getUuid()->toString(),
                ])
            );

            if (! $this->isPost()) {
                return new HtmlResponse(
                    $this->template->render('admin::delete-admin-modal-content', [
                        'form'  => $form,
                        'admin' => $admin,
                    ]),
                );
            }

            $form->setData($this->getPostParams());
            if ($form->isValid()) {
                $this->adminService->getAdminRepository()->deleteAdmin($admin);

                $this->messenger->addSuccess(Message::ADMIN_DELETED_SUCCESSFULLY);
                return new EmptyResponse(StatusCodeInterface::STATUS_CREATED);
            } else {
                return new HtmlResponse(
                    $this->template->render('admin::delete-admin-modal-content', [
                        'form'  => $form,
                        'admin' => $admin,
                    ]),
                    StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
                );
            }
        } catch (Throwable $exception) {
            $this->logErrors($exception, Message::DELETE_ADMIN);
            $this->messenger->addError(Message::AN_ERROR_OCCURRED);
            return new EmptyResponse(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function listAction(): ResponseInterface
    {
        $params = [
            'offset' => $this->getQueryParam('offset', 0, 'int'),
            'limit'  => $this->getQueryParam('limit', 10, 'int'),
            'sort'   => $this->getQueryParam('sort', 'created'),
            'order'  => $this->getQueryParam('order', 'desc'),
            'search' => $this->getQueryParam('search'),
            'status' => $this->getQueryParam('status'),
        ];

        $result = $this->adminService->getAdmins(
            $params['offset'],
            $params['limit'],
            $params['search'],
            $params['sort'],
            $params['order'],
        );

        $settings = $this->settingService->findOneBy([
            'admin'      => $this->adminService->getAdminRepository()->findOneBy([
                'identity' => $this->authenticationService->getIdentity()->getIdentity(),
            ]),
            'identifier' => Setting::IDENTIFIER_TABLE_ADMIN_LIST_SELECTED_COLUMNS,
        ]);

        $this->adminForm->setAttribute('action', $this->router->generateUri('admin', ['action' => 'add']));

        return new HtmlResponse(
            $this->template->render('admin::list', [
                'params'     => $params,
                'admins'     => $result['rows'],
                'statuses'   => Admin::STATUSES,
                'settings'   => $settings?->getValue() ?? [],
                'identifier' => Setting::IDENTIFIER_TABLE_ADMIN_LIST_SELECTED_COLUMNS,
                'form'       => $this->adminForm,
                'pagination' => new Pagination($result['total'], $result['offset'], $result['limit']),
            ])
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

        $accountForm->setAttribute('action', $this->router->generateUri('admin', ['action' => 'account']));
        $changePasswordForm->setAttribute(
            'action',
            $this->router->generateUri('admin', ['action' => 'change-password'])
        );

        $identity = $this->authenticationService->getIdentity();
        $admin    = $this->adminService->getAdminRepository()->findOneBy(['uuid' => $identity->getUuid()]);

        if (! $this->isPost()) {
            $accountForm->bind($admin);
            return new HtmlResponse(
                $this->template->render('admin::account', [
                    'accountForm'        => $accountForm->prepare(),
                    'changePasswordForm' => $changePasswordForm->prepare(),
                ])
            );
        }

        $accountForm->setData($this->getPostParams());
        if (! $accountForm->isValid()) {
            return new HtmlResponse(
                $this->template->render('admin::account', [
                    'accountForm'        => $accountForm->prepare(),
                    'changePasswordForm' => $changePasswordForm->prepare(),
                ])
            );
        }

        try {
            /** @var array $result */
            $result = $accountForm->getData();

            $this->adminService->updateAdmin($admin, $result);
            $this->messenger->addSuccess(Message::ACCOUNT_UPDATE_SUCCESSFULLY);
        } catch (IdentityException $e) {
            $this->logErrors($e, Message::UPDATE_ADMIN);
            $this->messenger->addError($e->getMessage());
        } catch (Throwable $e) {
            $this->logErrors($e, Message::UPDATE_ADMIN);
            $this->messenger->addError(Message::AN_ERROR_OCCURRED);
        }

        return new RedirectResponse($this->router->generateUri('admin', ['action' => 'account']));
    }

    public function changePasswordAction(): ResponseInterface
    {
        $changePasswordForm = new ChangePasswordForm();
        $accountForm        = new AccountForm();

        $accountForm->setAttribute('action', $this->router->generateUri('admin', ['action' => 'account']));
        $changePasswordForm->setAttribute(
            'action',
            $this->router->generateUri('admin', ['action' => 'change-password'])
        );

        if (! $this->isPost()) {
            return new HtmlResponse(
                $this->template->render('admin::account', [
                    'accountForm'        => $accountForm->prepare(),
                    'changePasswordForm' => $changePasswordForm->prepare(),
                ])
            );
        }

        /** @var AdminIdentity $adminIdentity */
        $adminIdentity = $this->authenticationService->getIdentity();
        $admin         = $this->adminService->getAdminRepository()->findOneBy([
            'identity' => $adminIdentity->getIdentity(),
        ]);

        $changePasswordForm->setData($this->getPostParams());
        if (! $changePasswordForm->isValid()) {
            return new HtmlResponse(
                $this->template->render('admin::account', [
                    'accountForm'        => $accountForm->prepare(),
                    'changePasswordForm' => $changePasswordForm->prepare(),
                ])
            );
        }

        try {
            /** @var array $result */
            $result = $changePasswordForm->getData();
            if ($admin->verifyPassword($result['currentPassword'])) {
                $this->adminService->updateAdmin($admin, $result);
                $this->messenger->addSuccess(Message::ACCOUNT_UPDATE_SUCCESSFULLY);
            } else {
                $this->messenger->addError(Message::CURRENT_PASSWORD_INCORRECT);
            }
        } catch (IdentityException $e) {
            $this->logErrors($e, Message::CHANGE_PASSWORD);
            $this->messenger->addError($e->getMessage());
        } catch (Throwable $e) {
            $this->logErrors($e, Message::CHANGE_PASSWORD);
            $this->messenger->addError(Message::AN_ERROR_OCCURRED);
        }

        return new RedirectResponse($this->router->generateUri('admin', ['action' => 'account']));
    }

    public function loginsAction(): ResponseInterface
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
            $this->template->render('admin::list-logins', [
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
