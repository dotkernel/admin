<?php
/**
 * @copyright: DotKernel
 * @package: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/21/2016
 * Time: 2:28 PM
 */

namespace Dot\Admin\Controller;

use Dot\Admin\Entity\AdminEntity;
use Dot\Admin\Form\Admin\AdminForm;


/**
 * Class AdminController
 * @package Dot\Authentication\Controller
 */
class AdminController extends EntityManageBaseController
{
    const ENTITY_NAME_SINGULAR = 'admin';
    const ENTITY_NAME_PLURAL = 'admins';
    const ENTITY_ROUTE_NAME = 'user';
    const ENTITY_TEMPLATE_NAME = 'entity-manage::admin-table';

    /**
     * @param AdminForm $form
     * @param AdminEntity $entity
     * @param array $data
     */
    public function customizeEditValidation(AdminForm $form, AdminEntity $entity, array $data)
    {
        //make password field optional for updates if both are empty in the POST data
        if (empty($data['admin']['password']) && empty($data['user']['passwordVerify'])) {
            $form->getInputFilter()->get('admin')->get('password')->setRequired(false);
            $form->getInputFilter()->get('admin')->get('passwordVerify')->setRequired(false);
        }

        //remove username and email checks if the value has not changed relative to the original
        if ($entity->getUsername() === $data['admin']['username']) {
            $form->removeUsernameValidation();
        }

        if ($entity->getEmail() === $data['admin']['email']) {
            $form->removeEmailValidation();
        }

        $form->applyValidationGroup();
    }
}