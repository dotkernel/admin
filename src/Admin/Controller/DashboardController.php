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
use Zend\Diactoros\Response\RedirectResponse;

/**
 * Class DashboardController
 * @package Dot\Authentication\Controller
 */
class DashboardController extends AbstractActionController
{
    /**
     * @return HtmlResponse|RedirectResponse
     */
    public function indexAction()
    {
        return new HtmlResponse($this->template()->render('app::dashboard'));
    }
}
