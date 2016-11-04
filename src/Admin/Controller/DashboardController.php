<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 10/26/2016
 * Time: 7:37 PM
 */

namespace Dot\Admin\Controller;

use Dot\Controller\AbstractActionController;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class DashboardController
 * @package Dot\Admin\Controller
 */
class DashboardController extends AbstractActionController
{
    public function indexAction()
    {
        //var_dump($this->authentication()->getIdentity());
        return new HtmlResponse($this->template()->render('app::dashboard'));
    }
}