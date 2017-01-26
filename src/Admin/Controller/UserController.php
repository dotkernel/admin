<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/4/2016
 * Time: 7:58 PM
 */

namespace Dot\Admin\Controller;

use Dot\Admin\Entity\User\UserEntity;
use Dot\Admin\Form\User\UserForm;
use Dot\Admin\Service\EntityServiceInterface;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;

/**
 * Class UserController
 * @package Dot\Authentication\User\Controller
 *
 * @Service
 */
class UserController extends EntityManageBaseController
{
    const ENTITY_NAME_SINGULAR = 'user';
    const ENTITY_NAME_PLURAL = 'users';
    const ENTITY_ROUTE_NAME = 'f_user';
    const ENTITY_TEMPLATE_NAME = 'entity-manage::user-table';

    const ENTITY_FORM_NAME = 'user';
    const ENTITY_DELETE_FORM_NAME = 'confirm_delete';

    /**
     * UserController constructor.
     * @param EntityServiceInterface $service
     *
     * @Inject({"dot-ems.service.user"})
     */
    public function __construct(EntityServiceInterface $service)
    {
        parent::__construct($service);
    }

    /**
     * @param bool $debug
     * @return EntityManageBaseController
     *
     * @Inject({"config.debug"})
     */
    public function setDebug($debug)
    {
        return parent::setDebug($debug);
    }

    /**
     * @param UserForm $form
     * @param UserEntity $entity
     * @param array $data
     */
    public function customizeEditValidation(UserForm $form, UserEntity $entity, array $data)
    {
        //make password field optional for updates if both are empty in the POST data
        if (empty($data['user']['password']) && empty($data['user']['passwordVerify'])) {
            $form->getInputFilter()->get('user')->get('password')->setRequired(false);
            $form->getInputFilter()->get('user')->get('passwordVerify')->setRequired(false);
        }

        //remove username and email checks if the value has not changed relative to the original
        if ($entity->getUsername() === $data['user']['username']) {
            $form->removeUsernameValidation();
        }

        if ($entity->getEmail() === $data['user']['email']) {
            $form->removeEmailValidation();
        }

        $form->applyValidationGroup();
    }
}
