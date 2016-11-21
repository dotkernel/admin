<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/4/2016
 * Time: 12:47 AM
 */

namespace Dot\Admin\Admin\Controller;

use Dot\Admin\Admin\Entity\AdminEntity;
use Dot\Admin\Admin\Form\AdminForm;
use Dot\Admin\Admin\Service\AdminServiceInterface;
use Dot\Admin\Admin\UIMessages;
use Dot\Controller\AbstractActionController;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\User\Result\UserOperationResult;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Form\Element\Select;
use Zend\Form\Form;

/**
 * Class AdminController
 * @package Dot\Admin\Admin\Controller
 */
class AdminController extends AbstractActionController
{
    /** @var  AdminServiceInterface */
    protected $adminService;

    /** @var  Form */
    protected $adminForm;

    /** @var  Form */
    protected $confirmDeleteForm;

    /** @var  AdminEntity */
    protected $adminEntityPrototype;

    /**
     * AdminController constructor.
     * @param AdminServiceInterface $adminService
     * @param Form $adminForm
     * @param Form $confirmDeleteForm
     */
    public function __construct(AdminServiceInterface $adminService, Form $adminForm, Form $confirmDeleteForm)
    {
        $this->adminService = $adminService;
        $this->adminForm = $adminForm;
        $this->confirmDeleteForm = $confirmDeleteForm;
    }

    /**
     * @return RedirectResponse
     */
    public function indexAction()
    {
        return new RedirectResponse($this->url()->generate('user', ['action' => 'manage']));
    }

    /**
     * This action offers both the html and json response
     * json response is used by table to fetch data through ajax
     * @return HtmlResponse|JsonResponse
     */
    public function manageAction()
    {
        $listUri = $this->url()->generate('user', ['action' => 'list']);
        $addUri = $this->url()->generate('user', ['action' => 'add']);
        $editUri = $this->url()->generate('user', ['action' => 'edit']);
        $deleteUri = $this->url()->generate('user', ['action' => 'delete']);

        return new HtmlResponse($this->template()->render('entity-manage::admin-table',
            ['listUri' => $listUri, 'editUri' => $editUri, 'addUri' => $addUri,
                'deleteUri' => $deleteUri, 'entityNameSingular' => 'admin', 'entityNamePlural' => 'admins']));
    }

    /**
     * @return JsonResponse
     */
    public function listAction()
    {
        //get query params as sent by bootstrap-table
        $params = $this->request->getQueryParams();
        $limit = isset($params['limit']) ? (int)$params['limit'] : 30;
        $offset = isset($params['offset']) ? (int)$params['offset'] : 0;

        /** @var HydratingResultSet $admins */
        $admins = $this->adminService->getAdminsPaginated($params, $limit, $offset);
        return new JsonResponse($admins);
    }

    /**
     * @return HtmlResponse|JsonResponse
     */
    public function addAction()
    {
        $request = $this->request;
        $form = $this->adminForm;

        //set default select values
        /** @var Select $roleSelect */
        $roleSelect = $form->getBaseFieldset()->get('role');
        $options = $roleSelect->getValueOptions();
        $options[1]['selected'] = true;
        $roleSelect->setValueOptions($options);

        /** @var Select $statusSelect */
        $statusSelect = $form->getBaseFieldset()->get('status');
        $options = $statusSelect->getValueOptions();
        $options[1]['selected'] = true;
        $statusSelect->setValueOptions($options);

        if ($request->getMethod() === 'POST') {

            $data = $request->getParsedBody();

            $form->bind($this->getAdminEntityPrototype());
            $form->setData($data);

            if ($form->isValid()) {
                /** @var AdminEntity $admin */
                $admin = $form->getData();
                //var_dump($admin);exit;
                /** @var UserOperationResult $result */
                $result = $this->adminService->saveAdmin($admin);

                if ($result->isValid()) {
                    return $this->generateJsonOutput((array)$result->getMessages());
                } else {
                    return $this->generateJsonOutput((array)$result->getMessages(), 'error');
                }
            } else {
                return $this->generateJsonOutput($form->getMessages(), 'validation', $form);
            }
        }

        return new HtmlResponse($this->template()->render('partial::ajax-form',
            ['form' => $form, 'formAction' => $this->url()->generate('user', ['action' => 'add'])]));
    }

    /**
     * @return HtmlResponse|JsonResponse
     */
    public function editAction()
    {
        $request = $this->getRequest();
        $id = $request->getAttribute('id');
        if (!$id) {
            return $this->generateJsonOutput([UIMessages::ADMIN_ACCOUNT_EDIT_NO_ID], 'error');
        }

        /** @var AdminEntity $admin */
        $admin = $this->adminService->getAdminById($id);

        if (!$admin) {
            return $this->generateJsonOutput([UIMessages::ADMIN_ACCOUNT_EDIT_INVALID_ID], 'error');
        }

        /** @var AdminForm $form */
        $form = $this->adminForm;
        $form->bind($admin);

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();

            //make password field optional for updates
            $form->getInputFilter()->get('admin')->get('password')->setRequired(false);
            $form->getInputFilter()->get('admin')->get('passwordVerify')->setRequired(false);

            //remove username and email checks if the value has not changed relative to the original
            if ($admin->getUsername() === $data['admin']['username']) {
                $form->removeUsernameValidation();
            }

            if ($admin->getEmail() === $data['admin']['email']) {
                $form->removeEmailValidation();
            }

            $form->applyValidationGroup();

            $form->setData($data);

            if ($form->isValid()) {
                /** @var AdminEntity $admin */
                $admin = $form->getData();

                /** @var UserOperationResult $result */
                $result = $this->adminService->saveAdmin($admin);

                if ($result->isValid()) {
                    return $this->generateJsonOutput((array)$result->getMessages(), 'success');
                } else {
                    return $this->generateJsonOutput((array)$result->getMessages(), 'error');
                }
            } else {
                return $this->generateJsonOutput($form->getMessages(), 'validation', $form);
            }
        }

        return new HtmlResponse($this->template()->render('partial::ajax-form',
            ['form' => $form, 'formAction' => $this->url()->generate('user', ['action' => 'edit', 'id' => $id])]));
    }

    /**
     * @return HtmlResponse|JsonResponse|RedirectResponse
     */
    public function deleteAction()
    {
        $request = $this->getRequest();
        $form = $this->confirmDeleteForm;

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();

            if (isset($data['admins']) && is_array($data['admins'])) {
                return new HtmlResponse($this->template()
                    ->render('partial::delete-form',
                        ['form' => $form, 'admins' => $data['admins']]));
            } else {
                //used to validate CSRF token
                $form->setData($data);

                if($form->isValid()) {
                    $ids = isset($data['ids']) && is_array($data['ids']) ? $data['ids'] : [];
                    $confirm = isset($data['confirm']) ? $data['confirm'] : 'no';
                    $markAsDeleted = isset($data['markAsDeleted']) ? $data['markAsDeleted'] : 'yes';

                    if (!empty($ids) && $confirm === 'yes') {
                        $markAsDeleted = $markAsDeleted === 'no' ? false : true;

                        /** @var UserOperationResult $result */
                        $result = $this->adminService->deleteAdminsById($ids, $markAsDeleted);

                        if ($result->isValid()) {
                            return $this->generateJsonOutput((array) $result->getMessages());
                        } else {
                            return $this->generateJsonOutput((array) $result->getMessages(), 'error');
                        }
                    }
                    else {
                        //do nothing
                        return $this->generateJsonOutput(['Operation was not confirmed. No changes were made'], 'info');
                    }
                } else {
                    return $this->generateJsonOutput($form->getMessages(), 'validation', $form);
                }
            }
        }

        //redirect to manage page if trying to access this action via GET
        return new RedirectResponse($this->url()->generate('user', ['action' => 'manage']));
    }

    /**
     * @param array $messages
     * @param string $type
     * @param Form|null $form
     * @return JsonResponse
     */
    protected function generateJsonOutput(array $messages, $type = 'success', Form $form = null)
    {
        $dismissible = true;
        $typeToNamespace = [
            'success' => FlashMessengerInterface::SUCCESS_NAMESPACE,
            'error' => FlashMessengerInterface::ERROR_NAMESPACE,
            'info' => FlashMessengerInterface::INFO_NAMESPACE,
            'warning' => FlashMessengerInterface::WARNING_NAMESPACE,
            'validation' => FlashMessengerInterface::ERROR_NAMESPACE
        ];

        $alerts = $messages;
        if($type === 'validation' && $form) {
            $alerts = $this->getFormMessages($form->getMessages());
            $dismissible = false;
        }

        $output = [$type => $messages];
        //render the alerts partial to send it through ajax to be inserted into the DOM
        $output['alerts'] = $this->template()->render('dot-partial::alerts',
            ['dismissible' => $dismissible, 'messages' => [$typeToNamespace[$type] => $alerts]]);
        return new JsonResponse($output);
    }

    /**
     * @return AdminEntity
     */
    public function getAdminEntityPrototype()
    {
        if (!$this->adminEntityPrototype) {
            $this->adminEntityPrototype = new AdminEntity();
        }
        return $this->adminEntityPrototype;
    }

    /**
     * @param AdminEntity $adminEntityPrototype
     * @return AdminController
     */
    public function setAdminEntityPrototype($adminEntityPrototype)
    {
        $this->adminEntityPrototype = $adminEntityPrototype;
        return $this;
    }

    /**
     * @param array $formMessages
     * @return array
     */
    protected function getFormMessages(array $formMessages)
    {
        $messages = [];
        foreach ($formMessages as $message) {
            if (is_array($message)) {
                foreach ($message as $m) {
                    if (is_string($m)) {
                        $messages[] = $m;
                    } elseif (is_array($m)) {
                        $messages = array_merge($messages, $this->getFormMessages($message));
                        break;
                    }
                }
            }
        }

        return $messages;
    }


}