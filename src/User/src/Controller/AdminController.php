<?php

namespace Frontend\User\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Dot\Controller\AbstractActionController;
use Dot\FlashMessenger\FlashMessenger;
use Fig\Http\Message\RequestMethodInterface;
use Frontend\Plugin\FormsPlugin;
use Frontend\User\Form\AccountForm;
use Frontend\User\Form\AdminForm;
use Frontend\User\Form\ChangePasswordForm;
use Frontend\User\Form\LoginForm;
use Frontend\User\InputFilter\EditAdminInputFilter;
use Frontend\User\Service\AdminService;
use Frontend\User\Service\UserService;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AdminController
 * @package Frontend\User\Controller
 */
class AdminController extends AbstractActionController
{
    /** @var RouterInterface $router */
    protected RouterInterface $router;

    /** @var TemplateRendererInterface $template */
    protected TemplateRendererInterface $template;

    /** @var UserService $userService */
    protected UserService $userService;

    /** @var AdminService $adminService */
    protected AdminService $adminService;

    /** @var AuthenticationServiceInterface $authenticationService */
    protected AuthenticationServiceInterface $authenticationService;

    /** @var FlashMessenger $messenger */
    protected FlashMessenger $messenger;

    /** @var FormsPlugin $forms */
    protected FormsPlugin $forms;

    /** @var AdminForm $adminForm */
    protected AdminForm $adminForm;

    /**
     * AdminController constructor.
     * @param UserService $userService
     * @param AdminService $adminService
     * @param RouterInterface $router
     * @param TemplateRendererInterface $template
     * @param AuthenticationService $authenticationService
     * @param FlashMessenger $messenger
     * @param FormsPlugin $forms
     * @param AdminForm $adminForm
     */
    public function __construct(
        UserService $userService,
        AdminService $adminService,
        RouterInterface $router,
        TemplateRendererInterface $template,
        AuthenticationService $authenticationService,
        FlashMessenger $messenger,
        FormsPlugin $forms,
        AdminForm $adminForm
    ) {
        $this->userService = $userService;
        $this->router = $router;
        $this->template = $template;
        $this->authenticationService = $authenticationService;
        $this->messenger = $messenger;
        $this->forms = $forms;
        $this->adminForm = $adminForm;
        $this->adminService = $adminService;
    }

    /**
     * @return ResponseInterface
     */
    public function addAction(): ResponseInterface
    {
        $request = $this->request;

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $this->adminForm->setData($data);
            if ($this->adminForm->isValid()) {
                $result = $this->adminForm->getData();
                try {
                    $this->adminService->createAdmin($result);
                    return new JsonResponse(['success' => 'success', 'message' => 'Admin created successfully']);
                } catch (\Exception $e) {
                    return new JsonResponse(['success' => 'error', 'message' => $e->getMessage()]);
                }
            } else {
                return new JsonResponse(
                    [
                        'success' => 'error',
                        'message' => $this->forms->getMessagesAsString($this->adminForm)
                    ]
                );
            }
        }

        return new HtmlResponse(
            $this->template->render(
                'partial::ajax-form',
                [
                    'form' => $this->adminForm,
                    'formAction' => '/admin/add'
                ]
            )
        );
    }

    /**
     * @return ResponseInterface
     */
    public function editAction(): ResponseInterface
    {//verify if username and email already exists
        $request = $this->getRequest();
        $uuid = $request->getAttribute('uuid');

        $admin = $this->adminService->getAdminRepository()->find($uuid);

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $this->adminForm->setData($data);
            $this->adminForm->setDifferentInputFilter(new EditAdminInputFilter());
            if ($this->adminForm->isValid()) {
                $result = $this->adminForm->getData();
                try {
                    $this->adminService->updateAdmin($admin, $result);
                    return new JsonResponse(['success' => 'success', 'message' => 'Admin updated successfully']);
                } catch (\Exception $e) {
                    return new JsonResponse(['success' => 'error', 'message' => $e->getMessage()]);
                }
            } else {
                return new JsonResponse(
                    [
                        'success' => 'error',
                        'message' => $this->forms->getMessagesAsString($this->adminForm)
                    ]
                );
            }
        }

        $this->adminForm->bind($admin);

        return new HtmlResponse(
            $this->template->render(
                'partial::ajax-form',
                [
                    'form' => $this->adminForm,
                    'formAction' => '/admin/edit/' . $uuid
                ]
            )
        );
    }

    /**
     * @return JsonResponse
     */
    public function deleteAction()
    {
        $request = $this->getRequest();
        $data = $request->getParsedBody();

        if (!empty($data['uuid'])) {
            $admin = $this->adminService->getAdminRepository()->find($data['uuid']);
        } else {
            return new JsonResponse(['success' => 'error', 'message' => 'Could not find user']);
        }

        try {
            $this->adminService->getAdminRepository()->deleteAdmin($admin);
            return new JsonResponse(['success' => 'success', 'message' => 'Admin Deleted Successfully']);
        } catch (\Exception $e) {
            return new JsonResponse(['success' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function listAction()
    {
        $params = $this->getRequest()->getQueryParams();

        $search = (!empty($params['search'])) ? $params['search'] : null;
        $sort = (!empty($params['sort'])) ? $params['sort'] : "created";
        $order = (!empty($params['order'])) ? $params['order'] : "desc";
        $offset = (!empty($params['offset'])) ? $params['offset'] : 0;
        $limit = (!empty($params['limit'])) ? $params['limit'] : 30;

        $result = $this->adminService->getAdmins($offset, $limit, $search, $sort, $order);

        return new JsonResponse($result);
    }

    /**
     * @return HtmlResponse
     */
    public function manageAction()
    {
        return new HtmlResponse($this->template->render('admin::admin-list'));
    }

    /**
     * @return ResponseInterface
     */
    public function loginAction(): ResponseInterface
    {
        if ($this->authenticationService->hasIdentity()) {
            return new RedirectResponse($this->router->generateUri("dashboard"));
        }

        /** @var LoginForm $form */
        $form = new LoginForm();

        $shouldRebind = $this->messenger->getData('shouldRebind') ?? true;
        if ($shouldRebind) {
            $this->forms->restoreState($form);
        }

        if (RequestMethodInterface::METHOD_POST === $this->getRequest()->getMethod()) {
            $form->setData($this->getRequest()->getParsedBody());
            if ($form->isValid()) {
                $adapter = $this->authenticationService->getAdapter();
                $data = $form->getData();
                $adapter->setIdentity($data['username']);
                $adapter->setCredential($data['password']);
                $authResult = $this->authenticationService->authenticate();
                if ($authResult->isValid()) {
                    $identity = $authResult->getIdentity();
                    $this->authenticationService->getStorage()->write($identity);

                    return new RedirectResponse($this->router->generateUri('dashboard'));
                } else {
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
            $this->template->render('user::login', [
                'form' => $form
            ])
        );
    }

    /**
     * @return ResponseInterface
     */
    public function logoutAction(): ResponseInterface
    {
        $this->authenticationService->clearIdentity();
        return new RedirectResponse(
            $this->router->generateUri('admin', ['action' => 'login'])
        );
    }

    /**
     * @return HtmlResponse
     */
    public function accountAction()
    {
        $form = new AccountForm();
        $changePasswordForm = new ChangePasswordForm();

        return new HtmlResponse(
            $this->template->render('admin::account', [
                'form' => $form,
                'changePasswordForm' => $changePasswordForm
            ])
        );
    }
}
