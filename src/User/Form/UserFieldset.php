<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 2/28/2017
 * Time: 7:49 PM
 */

declare(strict_types = 1);

namespace Admin\User\Form;

use Admin\User\Entity\UserEntity;
use Dot\User\Entity\RoleEntity;

/**
 * Class UserFieldset
 * @package Admin\User\Form
 */
class UserFieldset extends \Dot\User\Form\UserFieldset
{
    const MESSAGE_ROLES_EMPTY = '<b>Roles</b> should have at least one role selected';

    public function __construct()
    {
        parent::__construct();
        $this->setName('f_user');
    }

    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'details',
            'type' => 'F_UserDetailsFieldset',
        ], ['priority' => -10]);

        $this->add([
            'name' => 'roles',
            'type' => 'EntitySelect',
            'options' => [
                'label' => 'Roles',
                'use_hidden_element' => true,
                'target' => RoleEntity::class,
                'property' => 'name',
            ],
            'attributes' => [
                'multiple' => true,
                'id' => 'rolesSelect'
            ]
        ], ['priority' => -25]);

        $this->add([
            'name' => 'status',
            'type' => 'select',
            'options' => [
                'label' => 'Account Status',
                'value_options' => [
                    ['value' => UserEntity::STATUS_PENDING, 'label' => UserEntity::STATUS_PENDING],
                    ['value' => UserEntity::STATUS_ACTIVE, 'label' => UserEntity::STATUS_ACTIVE],
                    ['value' => UserEntity::STATUS_INACTIVE, 'label' => UserEntity::STATUS_INACTIVE],
                    ['value' => UserEntity::STATUS_DELETED, 'label' => UserEntity::STATUS_DELETED],
                ]
            ],
        ], ['priority' => -30]);
    }

    public function getInputFilterSpecification()
    {
        $specs = parent::getInputFilterSpecification();
        $specs['roles'] = [
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'message' => static::MESSAGE_ROLES_EMPTY,
                    ]
                ]
            ]
        ];

        return $specs;
    }
}
