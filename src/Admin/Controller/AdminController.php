<?php
/**
 * @copyright: DotKernel
 * @package: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/21/2016
 * Time: 2:28 PM
 */

namespace Dot\Admin\Controller;


use Dot\Admin\Admin\Entity\AdminEntity;
use Dot\Admin\Admin\Form\AdminForm;
use Dot\User\Service\PasswordInterface;

class AdminController extends EntityManageBaseController
{
    const ENTITY_NAME_SINGULAR = 'admin';
    const ENTITY_NAME_PLURAL = 'admins';
    const ENTITY_ROUTE_NAME = 'user';
    const ENTITY_TEMPLATE_NAME = 'entity-manage::admin-table';

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
     * @return $this
     */
    public function setPasswordService(PasswordInterface $passwordService)
    {
        $this->passwordService = $passwordService;
        return $this;
    }

    public function editAction()
    {
        $request = $this->getRequest();
        /** @var AdminForm $form */
        $form = $this->entityForm;
        if($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();

            //make password field optional for updates
            $form->getInputFilter()->get('admin')->get('password')->setRequired(false);
            $form->getInputFilter()->get('admin')->get('passwordVerify')->setRequired(false);

            /** @var AdminEntity $entity */
            $entity = $form->getObject();
            //remove username and email checks if the value has not changed relative to the original
            if ($entity->getUsername() === $data['admin']['username']) {
                $form->removeUsernameValidation();
            }

            if ($entity->getEmail() === $data['admin']['email']) {
                $form->removeEmailValidation();
            }

            $form->applyValidationGroup();
        }

        return parent::editAction();
    }
}