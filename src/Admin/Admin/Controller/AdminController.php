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
        $formats = ['html', 'json'];
        $output = isset($this->request->getQueryParams()['output'])
            ? $this->request->getQueryParams()['output']
            : 'html';

        if(!in_array($output, $formats)) {
            $output = 'html';
        }

        switch($output) {
            case 'json':
                //get query params as sent by bootstrap-table
                $params = $this->request->getQueryParams();
                $limit = isset($params['limit']) ? (int) $params['limit'] : 30;
                $offset = isset($params['offset']) ? (int) $params['offset'] : 0;

                /** @var HydratingResultSet $admins */
                $admins = $this->adminService->getAdminsPaginated($params, $limit, $offset);
                return new JsonResponse($admins);
                break;

            default:
                return new HtmlResponse($this->template()->render('app::admin-manage', ['form' => $this->adminForm]));
                break;
        }

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
                } else {
                    $data = ['error' => (array) $result->getMessages()];
                }
            }
            else {
                $data = ['form_error' => $form->getMessages()];
            }

            return new JsonResponse($data);
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

    /*public function deleteAction()
    {

    }

    public function editAction()
    {

    }*/


}