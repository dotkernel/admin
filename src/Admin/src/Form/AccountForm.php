<?php
/**
 * @see https://github.com/dotkernel/admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/admin/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Admin\Admin\Form;

use Admin\Admin\Entity\AdminEntity;
use Admin\App\Messages;
use Dot\Validator\Mapper\NoRecordExists;
use Zend\Form\Form;
use Zend\Form\FormInterface;
use Zend\InputFilter\InputFilter;

/**
 * Class AccountForm
 * @package Admin\Admin\Form
 */
class AccountForm extends Form
{
    /**
     * AccountForm constructor.
     */
    public function __construct()
    {
        parent::__construct('accountForm');
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
            'name' => 'account_csrf',
            'type' => 'csrf',
            'options' => [
                'timeout' => 3600,
                'message' => Messages::CSRF_EXPIRED
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Update account'
            ]
        ], ['priority' => -100]);

        $this->setValidationGroup([
            'account_csrf',
            'user' => [
                'username',
                'email',
                'firstName',
                'lastName',
            ]
        ]);
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
