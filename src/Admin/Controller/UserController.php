<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/4/2016
 * Time: 7:58 PM
 */

namespace Dot\Admin\Controller;

use Dot\Admin\Entity\UserEntity;
use Dot\Admin\Form\User\UserForm;
use Dot\User\Service\PasswordInterface;

/**
 * Class UserController
 * @package Dot\Admin\User\Controller
 */
class UserController extends EntityManageBaseController
{
    const ENTITY_NAME_SINGULAR = 'user';
    const ENTITY_NAME_PLURAL = 'users';
    const ENTITY_ROUTE_NAME = 'f_user';
    const ENTITY_TEMPLATE_NAME = 'entity-manage::user-table';

    /** @var  PasswordInterface */
    protected $passwordService;

    /**
     * @return PasswordInterface
     */
    public function getPasswordService()
    {
        return $this->passwordService;
    }

    /**
     * @param PasswordInterface $passwordService
     * @return UserController
     */
    public function setPasswordService(PasswordInterface $passwordService)
    {
        $this->passwordService = $passwordService;
        return $this;
    }

    public function editAction()
    {
        $request = $this->getRequest();
        /** @var UserForm $form */
        $form = $this->entityForm;
        if($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();

            //make password field optional for updates
            $form->getInputFilter()->get('user')->get('password')->setRequired(false);
            $form->getInputFilter()->get('user')->get('passwordVerify')->setRequired(false);

            /** @var UserEntity $entity */
            $entity = $form->getObject();
            //remove username and email checks if the value has not changed relative to the original
            if ($entity->getUsername() === $data['user']['username']) {
                $form->removeUsernameValidation();
            }

            if ($entity->getEmail() === $data['user']['email']) {
                $form->removeEmailValidation();
            }

            $form->applyValidationGroup();
        }

        return parent::editAction();
    }
}