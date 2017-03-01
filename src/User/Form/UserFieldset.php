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

/**
 * Class UserFieldset
 * @package Admin\User\Form
 */
class UserFieldset extends \Dot\User\Form\UserFieldset
{
    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'details',
            'type' => 'UserDetailsFieldset',
        ], ['priority' => -10]);

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
        ], ['priority' => -21]);
    }
}
