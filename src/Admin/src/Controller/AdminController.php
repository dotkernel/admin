<?php
/**
 * @see https://github.com/dotkernel/dot-admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-admin/blob/master/LICENSE.md MIT License
 */

namespace Admin\Admin\Controller;

use Admin\Admin\Entity\AdminEntity;
use Admin\Admin\Form\AdminForm;
use Admin\Admin\Service\AdminService;
use Admin\App\Controller\EntityManageBaseController;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;
use Dot\User\Event\UserControllerEvent;
use Dot\User\Event\UserControllerEventListenerInterface;
use Dot\User\Event\UserControllerEventListenerTrait;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\Uri;

/**
 * Class AdminController
 * @package Dot\Authentication\Controller
 *
 * @Service
 */
class AdminController extends EntityManageBaseController implements UserControllerEventListenerInterface
{
    use UserControllerEventListenerTrait;

    const ENTITY_NAME_SINGULAR = 'admin';
    const ENTITY_NAME_PLURAL = 'admins';
    const ENTITY_ROUTE_NAME = 'user';
    const ENTITY_TEMPLATE_NAME = 'app::admin-table';

    const ENTITY_FORM_NAME = 'Admin';
    const ENTITY_DELETE_FORM_NAME = 'ConfirmDelete';
    const DEFAULT_SORTED_COLUMN = 'dateCreated';

    /**
     * AdminController constructor.
     * @param AdminService $service
     *
     * @Inject({AdminService::class})
     */
    public function __construct(AdminService $service)
    {
        parent::__construct($service);
    }

    /**
     * @param AdminForm $form
     * @param AdminEntity $entity
     * @param array $data
     */
    public function customizeEditValidation(AdminForm $form, AdminEntity $entity, array $data)
    {
        //make password field optional for updates if both are empty in the POST data
        if (empty($data['user']['password']) && empty($data['user']['passwordConfirm'])) {
            $form->disablePasswordValidation();
            $entity->needsPasswordRehash(false);
        }
    }

    /**
     * @return ResponseInterface
     */
    public function changePasswordAction(): ResponseInterface
    {
        // change uri to account uri, as there is the form, so PRG will go there
        $this->request = $this->request->withUri(new Uri($this->url('user', ['action' => 'account'])));

        // this overwrites the original action, in order to redirect to /admin/account, where change password is moved
        // this happens only on GET, POST will go through the original action in order to process the request
        // as the original action does a PRG(post-redirect-get) it will go to the account action after processing update
        // this is what we actually want
        if ($this->getRequest()->getMethod() === 'GET') {
            return new RedirectResponse($this->url('user', ['action' => 'account']));
        }

        $delegate = $this->getDelegate();
        return $delegate->process($this->getRequest());
    }

    /**
     * @param UserControllerEvent $e
     */
    public function onBeforeAccountRender(UserControllerEvent $e)
    {
        // inject the ChangePassword form
        $e->setParam('changePasswordForm', $this->forms('ChangePassword'));
        $e->setParam('changePasswordAction', $this->url('user', ['action' => 'change-password']));
    }
}
