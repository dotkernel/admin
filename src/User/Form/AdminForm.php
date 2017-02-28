<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 2/28/2017
 * Time: 4:49 PM
 */

declare(strict_types = 1);

namespace Admin\User\Form;

use Admin\User\Entity\AdminEntity;
use Admin\User\Messages;
use Dot\Validator\Ems\NoRecordExists;
use Zend\Form\Form;
use Zend\Form\FormInterface;
use Zend\InputFilter\InputFilter;

/**
 * Class AdminForm
 * @package Admin\User\Form
 */
class AdminForm extends Form
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct('adminForm', $options);

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

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Save'
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
            $usernameValidators = $this->getInputFilter()->get('admin')->get('username')
                ->getValidatorChain()->getValidators();
            foreach ($usernameValidators as $validator) {
                $validator = $validator['instance'];
                if ($validator instanceof NoRecordExists) {
                    $validator->setExclude(['field' => 'id', 'value' => $object->getId()]);
                    break;
                }
            }
            $emailValidators = $this->getInputFilter()->get('admin')->get('email')
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
