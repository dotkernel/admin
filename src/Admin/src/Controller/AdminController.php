<?php

declare(strict_types=1);

namespace Frontend\Admin\Controller;

use Doctrine\ORM\NonUniqueResultException;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\Controller\AbstractActionController;
use Dot\FlashMessenger\FlashMessengerInterface;
use Frontend\Admin\Adapter\AuthenticationAdapter;
use Frontend\Admin\Entity\Admin;
use Frontend\Admin\Entity\AdminIdentity;
use Frontend\Admin\Entity\AdminLogin;
use Frontend\Admin\Form\AccountForm;
use Frontend\Admin\Form\AdminForm;
use Frontend\Admin\Form\ChangePasswordForm;
use Frontend\Admin\Form\LoginForm;
use Frontend\Admin\FormData\AdminFormData;
use Frontend\Admin\InputFilter\EditAdminInputFilter;
use Frontend\Admin\Service\AdminServiceInterface;
use Frontend\App\Common\ServerRequestAwareTrait;
use Frontend\App\Plugin\FormsPlugin;
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

use function password_verify;

class AdminController extends AbstractActionController
{
    use ServerRequestAwareTrait;

    /**
     * @Inject({
     *     AdminServiceInterface::class,
     *     RouterInterface::class,
     *     TemplateRendererInterface::class,
     *     AuthenticationServiceInterface::class,
     *     FlashMessengerInterface::class,
     *     FormsPlugin::class,
     *     AdminForm::class
     * })
     */
    public function __construct(
        protected AdminServiceInterface $adminService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected AuthenticationServiceInterface $authenticationService,
        protected FlashMessengerInterface $messenger,
        protected FormsPlugin $forms,
        protected AdminForm $adminForm
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
                    return new JsonResponse(['success' => 'success', 'message' => 'Admin created successfully']);
                } catch (Throwable $e) {
                    return new JsonResponse(['success' => 'error', 'message' => $e->getMessage()]);
                }
            } else {
                return new JsonResponse(
                    [
                        'success' => 'error',
                        'message' => $this->forms->getMessagesAsString($this->adminForm),
                    ]
                );
            }
        }

        return new HtmlResponse(
            $this->template->render(
                'partial::ajax-form',
                [
                    'form'       => $this->adminForm,
                    'formAction' => '/admin/add',
                ]
            )
        );
    }

    /**
     * @throws NonUniqueResultException
     */
    public function editAction(): ResponseInterface
    {
        $uuid = $this->getAttribute('uuid');

        /** @var Admin $admin */
        $admin = $this->adminService->getAdminRepository()->find($uuid);

        $adminFormData = (new AdminFormData())->fromEntity($admin);

        if ($this->isPost()) {
            $this->adminForm->setData($this->getPostParams());
            $this->adminForm->setDifferentInputFilter(new EditAdminInputFilter());
            if ($this->adminForm->isValid()) {
                /** @var array $result */
                $result = $this->adminForm->getData();
                try {
                    $this->adminService->updateAdmin($admin, $result);
                    return new JsonResponse(['success' => 'success', 'message' => 'Admin updated successfully']);
                } catch (Throwable $e) {
                    return new JsonResponse(['success' => 'error', 'message' => $e->getMessage()]);
                }
            } else {
                return new JsonResponse(
                    [
                        'success' => 'error',
                        'message' => $this->forms->getMessagesAsString($this->adminForm),
                    ]
                );
            }
        }

        $this->adminForm->bind($adminFormData);

        return new HtmlResponse(
            $this->template->render(
                'partial::ajax-form',
                [
                    'form'       => $this->adminForm,
                    'formAction' => '/admin/edit/' . $uuid,
                ]
            )
        );
    }

    /**
     * @throws NonUniqueResultException
     */
    public function deleteAction(): ResponseInterface
    {
        $uuid = $this->getPostParam('uuid');
        if (empty($uuid)) {
            return new JsonResponse(['success' => 'error', 'message' => 'Could not find admin']);
        }

        /** @var Admin $admin */
        $admin = $this->adminService->getAdminRepository()->find($uuid);

        try {
            $this->adminService->getAdminRepository()->deleteAdmin($admin);
            return new JsonResponse(['success' => 'success', 'message' => 'Admin Deleted Successfully']);
        } catch (Throwable $e) {
            return new JsonResponse(['success' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * @throws NonUniqueResultException
     */
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

        $form = new LoginForm();

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
                $logAdmin   = $this->adminService->logAdminVisit($this->getServerParams(), $data['username']);
                if ($authResult->isValid()) {
                    $identity = $authResult->getIdentity();
                    $logAdmin->setLoginStatus(AdminLogin::LOGIN_SUCCESS);
                    $this->adminService->getAdminRepository()->saveAdminVisit($logAdmin);
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
                    $logAdmin->setLoginStatus(AdminLogin::LOGIN_FAIL);
                    $this->adminService->getAdminRepository()->saveAdminVisit($logAdmin);
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
                'form' => $form,
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
        $form               = new AccountForm();
        $changePasswordForm = new ChangePasswordForm();
        $identity           = $this->authenticationService->getIdentity();
        $admin              = $this->adminService->findAdminBy(['uuid' => $identity->getUuid()]);

        if ($this->isPost()) {
            $form->setData($this->getPostParams());
            if ($form->isValid()) {
                /** @var array $result */
                $result = $form->getData();
                try {
                    $this->adminService->updateAdmin($admin, $result);
                    $this->messenger->addSuccess('Your account was updated successfully');
                } catch (Throwable $e) {
                    $this->messenger->addError($e->getMessage());
                }
            } else {
                $this->messenger->addError($this->forms->getMessagesAsString($form));
            }
            return new RedirectResponse($this->router->generateUri('admin', ['action' => 'account']));
        }

        $form->bind($admin);

        return new HtmlResponse(
            $this->template->render('admin::account', [
                'form'               => $form,
                'changePasswordForm' => $changePasswordForm,
            ])
        );
    }

    public function changePasswordAction(): ResponseInterface
    {
        $changePasswordForm = new ChangePasswordForm();
        /** @var AdminIdentity $adminIdentity */
        $adminIdentity = $this->authenticationService->getIdentity();
        $admin         = $this->adminService->getAdminRepository()->findAdminBy([
            'identity' => $adminIdentity->getIdentity(),
        ]);

        if ($this->isPost()) {
            $changePasswordForm->setData($this->getPostParams());
            if ($changePasswordForm->isValid()) {
                /** @var array $result */
                $result = $changePasswordForm->getData();
                if (password_verify($result['currentPassword'], $admin->getPassword())) {
                    try {
                        $this->adminService->updateAdmin($admin, $result);
                        $this->messenger->addSuccess('Your account was updated successfully');
                    } catch (Throwable $e) {
                        $this->messenger->addError($e->getMessage());
                    }
                } else {
                    $this->messenger->addError('Current Password is incorrect');
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
}
