<?php
/**
 * @see https://github.com/dotkernel/admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/admin/blob/master/LICENSE.md MIT License
 */

namespace Admin\User\Controller;

use Admin\App\Controller\EntityManageBaseController;
use Admin\User\Entity\UserEntity;
use Admin\User\Form\UserForm;
use Admin\User\Service\UserService;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;

/**
 * Class UserController
 * @package Admin\User\Controller
 *
 * @Service
 */
class UserController extends EntityManageBaseController
{
    const ENTITY_NAME_SINGULAR = 'user';
    const ENTITY_NAME_PLURAL = 'users';
    const ENTITY_ROUTE_NAME = 'f_user';
    const ENTITY_TEMPLATE_NAME = 'app::user-table';

    const ENTITY_FORM_NAME = 'User';
    const ENTITY_DELETE_FORM_NAME = 'ConfirmDelete';
    const DEFAULT_SORTED_COLUMN = 'dateCreated';

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
        if (empty($data['f_user']['password']) && empty($data['f_user']['passwordConfirm'])) {
            $form->disablePasswordValidation();
            $entity->needsPasswordRehash(false);
        }
    }
}
