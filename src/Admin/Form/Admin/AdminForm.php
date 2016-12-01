<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/4/2016
 * Time: 7:38 PM
 */

namespace Dot\Admin\Form\Admin;

use Zend\Form\Element\Csrf;
use Zend\Form\Fieldset;
use Zend\Form\Form;
use Zend\Form\FormInterface;

/**
 * Class AdminForm
 * @package Dot\Authentication\Authentication\Form
 */
class AdminForm extends Form
{
    /** @var  Fieldset */
    protected $adminFieldset;

    protected $currentValidationGroups = [
        'id' => true, 'username' => true, 'email' => true, 'firstName' => true, 'lastName' => true,
        'password' => true, 'passwordVerify' => true,
        'role' => true, 'status' => true
    ];

    /**
     * AdminForm constructor.
     * @param Fieldset $adminFieldset
     * @param string $name
     * @param array $options
     */
    public function __construct(Fieldset $adminFieldset, $name = 'admin_form', array $options = [])
    {
        $this->adminFieldset = $adminFieldset;
        parent::__construct($name, $options);
    }

    public function init()
    {
        $this->adminFieldset->setName('admin');
        $this->adminFieldset->setUseAsBaseFieldset(true);
        $this->add($this->adminFieldset);

        $csrf = new Csrf('admin_csrf', [
            'csrf_options' => [
                'timeout' => 3600,
                'message' => 'The form used to make the request has expired. Please try again now'
            ]
        ]);
        $this->add($csrf);
    }

    public function removeUsernameValidation()
    {
        $this->currentValidationGroups['username'] = false;
    }

    public function removeEmailValidation()
    {
        $this->currentValidationGroups['email'] = false;
    }

    public function resetValidationGroup()
    {
        foreach ($this->currentValidationGroups as $key => $value) {
            $this->currentValidationGroups[$key] = true;
        }
        $this->setValidationGroup(FormInterface::VALIDATE_ALL);
    }

    public function applyValidationGroup()
    {
        $validationGroup = $this->getActiveValidationGroup($this->currentValidationGroups);
        $this->setValidationGroup(['admin' => $validationGroup]);
    }

    public function getActiveValidationGroup($groups)
    {
        $validationGroup = [];
        foreach ($groups as $key => $value) {
            if(is_array($value)) {
                $validationGroup[$key] = $this->getActiveValidationGroup($value);
            }
            elseif($value === true) {
                $validationGroup[] = $key;
            }
        }
        return $validationGroup;
    }


}