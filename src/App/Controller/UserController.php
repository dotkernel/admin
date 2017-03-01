<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/4/2016
 * Time: 7:58 PM
 */

namespace Dot\Admin\Controller;

use Admin\User\Entity\UserEntity;
use Admin\User\Form\UserForm;
use Admin\User\Service\UserService;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;

/**
 * Class UserController
 * @package Dot\Authentication\Admin\Controller
 *
 * @Service
 */
class UserController extends EntityManageBaseController
{
    const ENTITY_NAME_SINGULAR = 'user';
    const ENTITY_NAME_PLURAL = 'users';
    const ENTITY_ROUTE_NAME = 'f_user';
    const ENTITY_TEMPLATE_NAME = 'entity-manage::user-table';

    const ENTITY_FORM_NAME = 'User';
    const ENTITY_DELETE_FORM_NAME = 'ConfirmDelete';

    /**
     * UserController constructor.
     * @param UserService $service
     *
     * @Inject({UserService::class})
     */
    public function __construct(UserService $service)
    {
        parent::__construct($service);
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
    }
}
