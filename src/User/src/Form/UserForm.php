<?php
/**
 * @see https://github.com/dotkernel/admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/admin/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Admin\User\Form;

use Admin\App\Messages;
use Admin\User\Entity\UserEntity;
use Dot\Validator\Mapper\NoRecordExists;
use Zend\Form\Form;
use Zend\Form\FormInterface;
use Zend\InputFilter\InputFilter;

/**
 * Class UserForm
 * @package Admin\User\Form
 */
class UserForm extends Form
{
    protected $validationGroup = [
        'user_csrf',
        'f_user' => [
            'username',
            'email',
            'details' => [
                'firstName',
                'lastName',
                'phone',
                'address'
            ],
            'password',
            'passwordConfirm',
            'roles',
            'status',
        ]
    ];

    protected $noPasswordValidationGroup = [
        'user_csrf',
        'f_user' => [
            'username',
            'email',
            'details' => [
                'firstName',
                'lastName',
                'phone',
                'address'
            ],
            'roles',
            'status',
        ]
    ];

    /**
     * UserForm constructor.
     */
    public function __construct()
    {
        parent::__construct('userForm');

        $this->setAttribute('method', 'post');
        $this->setInputFilter(new InputFilter());
    }

    public function init()
    {
        $this->add([
            'type' => 'F_UserFieldset',
            'options' => [
                'use_as_base_fieldset' => true,
            ]
        ]);

        $this->add([
            'name' => 'user_csrf',
            'type' => 'csrf',
            'options' => [
                'timeout' => 3600,
                'message' => Messages::CSRF_EXPIRED
            ]
        ]);

        $this->setValidationGroup($this->validationGroup);
    }

    public function disablePasswordValidation()
    {
        $this->setValidationGroup($this->noPasswordValidationGroup);
    }

    public function resetValidation()
    {
        $this->setValidationGroup($this->validationGroup);
    }

    /**
     * @param object $object
     * @param int $flags
     * @return Form
     */
    public function bind($object, $flags = FormInterface::VALUES_NORMALIZED)
    {
        if ($object instanceof UserEntity) {
            $usernameValidators = $this->getInputFilter()->get('f_user')->get('username')
                ->getValidatorChain()->getValidators();
            foreach ($usernameValidators as $validator) {
                $validator = $validator['instance'];
                if ($validator instanceof NoRecordExists) {
                    $validator->setExclude(['field' => 'id', 'value' => $object->getId()]);
                    break;
                }
            }
            $emailValidators = $this->getInputFilter()->get('f_user')->get('email')
                ->getValidatorChain()->getValidators();
            foreach ($emailValidators as $validator) {
                $validator = $validator['instance'];
                if ($validator instanceof NoRecordExists) {
                    $validator->setExclude(['field' => 'id', 'value' => $object->getId()]);
                    break;
                }
            }
        }
        return parent::bind($object, $flags);
    }
}
