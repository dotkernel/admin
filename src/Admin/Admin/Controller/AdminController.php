<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/4/2016
 * Time: 12:47 AM
 */

namespace Dot\Admin\Admin\Controller;

use Dot\Admin\Admin\Service\AdminServiceInterface;
use Dot\Controller\AbstractActionController;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;

/**
 * Class AdminController
 * @package Dot\Admin\Admin\Controller
 */
class AdminController extends AbstractActionController
{
    /** @var  AdminServiceInterface */
    protected $adminService;

    /**
     * AdminController constructor.
     * @param AdminServiceInterface $adminService
     */
    public function __construct(AdminServiceInterface $adminService)
    {
        $this->adminService = $adminService;
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
    public function listAction()
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
                return new HtmlResponse($this->template()->render('app::admin-list'));
                break;
        }

    }

    /*public function addAction()
    {

    }

    public function deleteAction()
    {

    }

    public function editAction()
    {

    }*/
}