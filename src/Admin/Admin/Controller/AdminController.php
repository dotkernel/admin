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
use Dot\Admin\Admin\Service\AdminServiceInterface;
use Dot\Controller\AbstractActionController;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\User\Result\UserOperationResult;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;
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

        if($request->getMethod() === 'POST') {
            $form = $this->adminForm;
            $data = $request->getParsedBody();


            $form->bind($this->getAdminEntityPrototype());
            $form->setData($data);

            if($form->isValid()) {
                /** @var AdminEntity $admin */
                $admin = $form->getData();
                /** @var UserOperationResult $result */
                $result = $this->adminService->saveAdmin($admin);
                if($result->isValid()) {
                    $data = ['success' => (array) $result->getMessages()];
                    //render the alerts partial to send it through ajax to be inserted into the DOM
                    $data['alerts'] = $this->template()->render('dot-partial::alerts',
                            ['dismissible' => true, 'messages' => [FlashMessengerInterface::SUCCESS_NAMESPACE => $data['success']]]);
                } else {
                    $data = ['error' => (array) $result->getMessages()];
                    $data['alerts'] = $this->template()->render('dot-partial::alerts',
                            ['dismissible' => true, 'messages' => [FlashMessengerInterface::ERROR_NAMESPACE => $data['error']]]);
                }
            }
            else {
                $data = ['validation' => $form->getMessages()];
                $data['alerts'] = $this->template()->render('dot-partial::alerts',
                    ['messages' => [FlashMessengerInterface::ERROR_NAMESPACE =>
                        $this->getFormMessages($form->getMessages())]]);

            }

            return new JsonResponse($data);
        }

        return new HtmlResponse($this->template()->render('partial::admin-form',
            ['form' => $this->adminForm, 'formAction' => $this->url()->generate('user', ['action' => 'add'])]));
    }

    public function editAction()
    {

        $request = $this->getRequest();
        //var_dump($this->request->getParsedBody());exit;

        if($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            if(isset($data['ids'])) {
                //get selected admins and display edit form
                $ids = explode(',', $data['ids']);


                return new HtmlResponse($this->template()->render('app::admin-edit'));
            }
            else {

            }
        }

        //if not a POST, redirect to manage page, there is nothing HTML here
        return new RedirectResponse($this->url()->generate('user', ['action' => 'manage']));
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