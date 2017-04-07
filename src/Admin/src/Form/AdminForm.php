<?php
/**
 * @see https://github.com/dotkernel/admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/admin/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace Admin\Admin\Form;

use Admin\Admin\Entity\AdminEntity;
use Admin\App\Messages;
use Dot\Validator\Mapper\NoRecordExists;
use Zend\Form\Form;
use Zend\Form\FormInterface;
use Zend\InputFilter\InputFilter;

/**
 * Class AdminForm
 * @package Admin\Admin\Form
 */
class AdminForm extends Form
{
    protected $validationGroup = [
        'admin_csrf',
        'user' => [
            'username',
            'email',
            'firstName',
            'lastName',
            'password',
            'passwordConfirm',
            'roles',
            'status',
        ]
    ];

    protected $noPasswordValidationGroup = [
        'admin_csrf',
        'user' => [
            'username',
            'email',
            'firstName',
            'lastName',
            'roles',
            'status',
        ]
    ];

    /**
     * AdminForm constructor.
     */
    public function __construct()
    {
        parent::__construct('adminForm');

        $this->setAttribute('method', 'post');
        $this->setInputFilter(new InputFilter());
    }

    public function init()
    {
        $this->add([
            'type' => 'AdminFieldset',
            'options' => [
                'use_as_base_fieldset' => true,
            ]
        ]);

        $this->add([
            'name' => 'admin_csrf',
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
        if ($object instanceof AdminEntity) {
            $usernameValidators = $this->getInputFilter()->get('user')->get('username')
                ->getValidatorChain()->getValidators();
            foreach ($usernameValidators as $validator) {
                $validator = $validator['instance'];
                if ($validator instanceof NoRecordExists) {
                    $validator->setExclude(['field' => 'id', 'value' => $object->getId()]);
                    break;
                }
            }
            $emailValidators = $this->getInputFilter()->get('user')->get('email')
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
