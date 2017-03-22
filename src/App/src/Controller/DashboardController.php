<?php
/**
 * @see https://github.com/dotkernel/dot-admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-admin/blob/master/LICENSE.md MIT License
 */

namespace Admin\App\Controller;

use Dot\AnnotatedServices\Annotation\Service;
use Dot\Controller\AbstractActionController;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Dot\Controller\Plugin\Authentication\AuthenticationPlugin;
use Dot\Controller\Plugin\Authorization\AuthorizationPlugin;
use Dot\Controller\Plugin\FlashMessenger\FlashMessengerPlugin;
use Dot\Controller\Plugin\Forms\FormsPlugin;
use Dot\Controller\Plugin\TemplatePlugin;
use Dot\Controller\Plugin\UrlHelperPlugin;
use Zend\Session\Container;
use Psr\Http\Message\UriInterface;
use Zend\Form\Form;

/**
 * Class DashboardController
 * @package Dot\Authentication\Controller
 *
 * @method UrlHelperPlugin|UriInterface url($r = null, $p = [], $q = [], $f = null, $o = [])
 * @method FlashMessengerPlugin messenger()
 * @method FormsPlugin|Form forms(string $name = null)
 * @method TemplatePlugin|string template(string $template = null, array $params = [])
 * @method AuthenticationPlugin authentication()
 * @method AuthorizationPlugin isGranted(string $permission, array $roles = [], $context = null)
 * @method Container session(string $namespace)
 *
 * @Service
 */
class DashboardController extends AbstractActionController
{
    /**
     * @return HtmlResponse|RedirectResponse
     */
    public function indexAction()
    {
        return new HtmlResponse($this->template('app::dashboard'));
    }
}
