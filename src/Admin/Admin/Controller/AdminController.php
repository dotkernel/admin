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

    public function indexAction()
    {

    }

    public function listAction()
    {
        $formats = ['html', 'json'];
        $output = isset($this->request->getQueryParams()['output']) ? $this->request->getQueryParams()['output'] : 'html';
        if(!in_array($output, $formats)) {
            $output = 'html';
        }

        switch($output) {
            case 'json':
                /** @var HydratingResultSet $admins */
                $admins = $this->adminService->getAdmins();
                return new JsonResponse($admins->toArray());
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