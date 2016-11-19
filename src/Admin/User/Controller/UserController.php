<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/4/2016
 * Time: 7:58 PM
 */

namespace Dot\Admin\User\Controller;

use Dot\Controller\AbstractActionController;
use Dot\Ems\Service\EntityService;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Paginator\Paginator;

/**
 * Class UserController
 * @package Dot\Admin\User\Controller
 */
class UserController extends AbstractActionController
{
    /** @var  EntityService */
    protected $userService;

    public function __construct(EntityService $service)
    {
        $this->userService = $service;
    }

    public function indexAction()
    {
        return new RedirectResponse($this->url()->generate('f_user', ['action' => 'manage']));
    }

    public function manageAction()
    {
        $listUri = $this->url()->generate('f_user', ['action' => 'list']);
        $addUri = $this->url()->generate('f_user', ['action' => 'add']);
        $editUri = $this->url()->generate('f_user', ['action' => 'edit']);
        $deleteUri = $this->url()->generate('f_user', ['action' => 'delete']);

        return new HtmlResponse($this->template()->render('entity-manage::user-table',
            ['listUri' => $listUri, 'editUri' => $editUri, 'addUri' => $addUri,
                'deleteUri' => $deleteUri, 'entityNameSingular' => 'user', 'entityNamePlural' => 'users']));
    }

    public function listAction()
    {
        //get query params as sent by bootstrap-table
        $params = $this->request->getQueryParams();
        $limit = isset($params['limit']) ? (int)$params['limit'] : 30;
        $offset = isset($params['offset']) ? (int)$params['offset'] : 0;

        /** @var Paginator $paginator */
        $paginator = $this->userService->findAll([], $params, true);
        $paginator->setItemCountPerPage($limit);
        $paginator->setCurrentPageNumber(intval($offset/$limit));

        return new JsonResponse([
            'total' => $paginator->getTotalItemCount(),
            'rows' => (array) $paginator->getCurrentItems()]);
    }

    public function addAction()
    {

    }

    public function editAction()
    {

    }
}