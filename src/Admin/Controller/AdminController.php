<?php
/**
 * @copyright: DotKernel
 * @package: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/21/2016
 * Time: 2:28 PM
 */

namespace Dot\Admin\Controller;

use Dot\Admin\Entity\Admin\AdminEntity;
use Dot\Admin\Form\Admin\AdminForm;
use Dot\Admin\Service\EntityServiceInterface;
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
    const ENTITY_TEMPLATE_NAME = 'entity-manage::admin-table';

    const ENTITY_FORM_NAME = 'admin';
    const ENTITY_DELETE_FORM_NAME = 'confirm_delete';

    /**
     * AdminController constructor.
     * @param EntityServiceInterface $service
     *
     * @Inject({"dot-ems.service.admin"})
     */
    public function __construct(EntityServiceInterface $service)
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
        if (empty($data['admin']['password']) && empty($data['user']['passwordVerify'])) {
            $form->getInputFilter()->get('admin')->get('password')->setRequired(false);
            $form->getInputFilter()->get('admin')->get('passwordVerify')->setRequired(false);
        }

        //remove username and email checks if the value has not changed relative to the original
        if ($entity->getUsername() === $data['admin']['username']) {
            $form->setValidationForInput('admin.username', false);
        }

        if ($entity->getEmail() === $data['admin']['email']) {
            $form->setValidationForInput('admin.email', false);
        }

        $form->applyValidationGroup();
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
}
