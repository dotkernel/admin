<?php
/**
 * @copyright: DotKernel
 * @package: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/21/2016
 * Time: 2:28 PM
 */

namespace Admin\App\Controller;

use Admin\Admin\Entity\AdminEntity;
use Admin\Admin\Form\AdminForm;
use Admin\Admin\Service\AdminService;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;

/**
 * Class AdminController
 * @package Dot\Authentication\Controller
 *
 * @Service
 */
class AdminController extends EntityManageBaseController
{
    const ENTITY_NAME_SINGULAR = 'admin';
    const ENTITY_NAME_PLURAL = 'admins';
    const ENTITY_ROUTE_NAME = 'user';
    const ENTITY_TEMPLATE_NAME = 'admin::admin-table';

    const ENTITY_FORM_NAME = 'Admin';
    const ENTITY_DELETE_FORM_NAME = 'ConfirmDelete';

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
        if (empty($data['admin']['password']) && empty($data['admin']['passwordConfirm'])) {
            $form->disablePasswordValidation();
            $entity->needsPasswordRehash(false);
        }
    }
}
