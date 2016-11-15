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
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;

/**
 * Class UserController
 * @package Dot\Admin\User\Controller
 */
class UserController extends AbstractActionController
{
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

    }

    public function addAction()
    {

    }

    public function editAction()
    {

    }
}