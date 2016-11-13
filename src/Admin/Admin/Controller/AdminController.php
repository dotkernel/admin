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

    /** @var  AdminEntity */
    protected $adminEntityPrototype;

    /**
     * AdminController constructor.
     * @param AdminServiceInterface $adminService
     * @param Form $adminForm
     */
    public function __construct(AdminServiceInterface $adminService, Form $adminForm)
    {
        $this->adminService = $adminService;
        $this->adminForm = $adminForm;
    }

    /**
     * @return RedirectResponse
     */
    public function indexAction()
    {
        return new RedirectResponse($this->url()->generate('user', ['action' => 'list']));
    }

    /**
     * This action offers both the html and json response
     * json response is used by table to fetch data through ajax
     * @return HtmlResponse|JsonResponse
     */
    public function manageAction()
    {
        return new HtmlResponse($this->template()->render('app::admin-manage', ['form' => $this->adminForm]));
    }

    public function listAction()
    {
        //get query params as sent by bootstrap-table
        $params = $this->request->getQueryParams();
        $limit = isset($params['limit']) ? (int) $params['limit'] : 30;
        $offset = isset($params['offset']) ? (int) $params['offset'] : 0;

        /** @var HydratingResultSet $admins */
        $admins = $this->adminService->getAdminsPaginated($params, $limit, $offset);
        return new JsonResponse($admins);
    }


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

        if($request->getMethod() === 'POST') {

            $data = $request->getParsedBody();

            $form->bind($this->getAdminEntityPrototype());
            $form->setData($data);

            if($form->isValid()) {
                /** @var AdminEntity $admin */
                $admin = $form->getData();

                /** @var UserOperationResult $result */
                $result = $this->adminService->saveAdmin($admin);

                if($result->isValid()) {
                    $output = ['success' => (array) $result->getMessages()];
                    //render the alerts partial to send it through ajax to be inserted into the DOM
                    $output['alerts'] = $this->template()->render('dot-partial::alerts',
                            ['dismissible' => true, 'messages' => [FlashMessengerInterface::SUCCESS_NAMESPACE => $output['success']]]);
                } else {
                    $output = ['error' => (array) $result->getMessages()];
                    $output['alerts'] = $this->template()->render('dot-partial::alerts',
                            ['dismissible' => true, 'messages' => [FlashMessengerInterface::ERROR_NAMESPACE => $output['error']]]);
                }
            }
            else {
                $output = ['validation' => $form->getMessages()];
                $output['alerts'] = $this->template()->render('dot-partial::alerts',
                    ['messages' => [FlashMessengerInterface::ERROR_NAMESPACE =>
                        $this->getFormMessages($form->getMessages())]]);

            }

            return new JsonResponse($output);
        }

        return new HtmlResponse($this->template()->render('partial::admin-form',
            ['form' => $form, 'formAction' => $this->url()->generate('user', ['action' => 'add'])]));
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $id = $request->getAttribute('id');
        if(!$id) {
            $output = ['error' => 'No admin id selected for editing'];
            $output['alerts'] = $this->template()->render('dot-partial::alerts',
                ['dismissible' => true, 'messages' => [FlashMessengerInterface::ERROR_NAMESPACE => $output['error']]]);

            return new JsonResponse($output);
        }

        /** @var AdminEntity $admin */
        $admin = $this->adminService->getAdminById($id);

        if(!$admin) {
            $output = ['error' => 'Cannot load an admin with the specified ID'];
            $output['alerts'] = $this->template()->render('dot-partial::alerts',
                ['dismissible' => true, 'messages' => [FlashMessengerInterface::ERROR_NAMESPACE => $output['error']]]);

            return new JsonResponse($output);
        }

        /** @var AdminForm $form */
        $form = $this->adminForm;
        $form->bind($admin);

        if($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();

            //make password field optional for updates
            $form->getInputFilter()->get('admin')->get('password')->setRequired(false);
            $form->getInputFilter()->get('admin')->get('passwordVerify')->setRequired(false);

            //remove username and email checks if the value has not changed relative to the original
            if($admin->getUsername() === $data['admin']['username']) {
                $form->removeUsernameValidation();
            }

            if($admin->getEmail() === $data['admin']['email']) {
                $form->removeEmailValidation();
            }

            $form->applyValidationGroup();

            $form->setData($data);

            if($form->isValid()) {
                /** @var AdminEntity $admin */
                $admin = $form->getData();

                /** @var UserOperationResult $result */
                $result = $this->adminService->saveAdmin($admin);

                if($result->isValid()) {
                    $output = ['success' => (array) $result->getMessages()];
                    //render the alerts partial to send it through ajax to be inserted into the DOM
                    $output['alerts'] = $this->template()->render('dot-partial::alerts',
                        ['dismissible' => true, 'messages' => [FlashMessengerInterface::SUCCESS_NAMESPACE => $output['success']]]);
                } else {
                    $output = ['error' => (array) $result->getMessages()];
                    $output['alerts'] = $this->template()->render('dot-partial::alerts',
                        ['dismissible' => true, 'messages' => [FlashMessengerInterface::ERROR_NAMESPACE => $output['error']]]);
                }
            }
            else {
                $output = ['validation' => $form->getMessages()];
                $output['alerts'] = $this->template()->render('dot-partial::alerts',
                    ['messages' => [FlashMessengerInterface::ERROR_NAMESPACE =>
                        $this->getFormMessages($form->getMessages())]]);
            }

            return new JsonResponse($output);
        }

        return new HtmlResponse($this->template()->render('partial::admin-form',
            ['form' => $form, 'formAction' => $this->url()->generate('user', ['action' => 'edit', 'id' => $id])]));
    }

    /**
     * @return AdminEntity
     */
    public function getAdminEntityPrototype()
    {
        if(!$this->adminEntityPrototype) {
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