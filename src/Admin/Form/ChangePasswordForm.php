<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 3/7/2017
 * Time: 12:43 AM
 */

declare(strict_types = 1);

namespace Admin\Admin\Form;

use Admin\App\Messages;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

/**
 * Class ChangePasswordForm
 * @package Admin\Admin\Form
 */
class ChangePasswordForm extends Form implements InputFilterProviderInterface
{
    const CURRENT_PASSWORD_REQUIRED = '<b>Current password</b> is required and cannot be empty';

    /**
     * ChangePasswordForm constructor.
     */
    public function __construct()
    {
        parent::__construct('changePasswordForm');
        $this->setAttribute('method', 'post');
    }

    public function init()
    {
        $this->add([
            'name' => 'currentPassword',
            'type' => 'Password',
            'options' => [
                'label' => 'Your current password',
            ],
            'attributes' => [
                'placeholder' => 'Current password...',
                //'required' => 'required',
            ]
        ]);

        $this->add([
            'type' => 'AdminFieldset',
            'options' => [
                'use_as_base_fieldset' => true,
            ]
        ]);

        $this->add([
            'name' => 'change_password_csrf',
            'type' => 'Csrf',
            'options' => [
                'csrf_options' => [
                    'timeout' => 3600,
                    'message' => Messages::CSRF_EXPIRED
                ]
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Change password'
            ]
        ]);

        $this->getBaseFieldset()->get('password')
            ->setLabel('New password')
            ->setAttribute('placeholder', 'New password...');

        $this->getBaseFieldset()->get('passwordConfirm')
            ->setLabel('Confirm new password')
            ->setAttribute('placeholder', 'New password confirm...');

        $this->setValidationGroup([
            'change_password_csrf',
            'currentPassword',
            'user' => [
                'password',
                'passwordConfirm'
            ]
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'currentPassword' => [
                'validators' => [
                    [
                        'name' => 'NotEmpty',
                        'break_chain_on_failure' => true,
                        'options' => [
                            'message' => static::CURRENT_PASSWORD_REQUIRED,
                        ]
                    ]
                ]
            ]
        ];
    }
}
