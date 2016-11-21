<?php
/**
 * Created by PhpStorm.
 * User: n3vra
 * Date: 11/20/2016
 * Time: 4:49 AM
 */

namespace Dot\Admin\Form\User;

use Zend\Form\Element\Csrf;
use Zend\Form\Fieldset;
use Zend\Form\Form;
use Zend\Form\FormInterface;

/**
 * Class UserForm
 * @package Dot\Admin\User\Form
 */
class UserForm extends Form
{
    /** @var  Fieldset */
    protected $userFieldset;

    /** @var  Fieldset */
    protected $userDetailsFieldset;

    protected $currentValidationGroups = [
        'id' => true, 'username' => true, 'email' => true, 'firstName' => true, 'lastName' => true,
        'password' => true, 'passwordVerify' => true,
        'role' => true, 'status' => true
    ];

    public function __construct(Fieldset $userFieldset, Fieldset $userDetailsFieldset, $options = [])
    {
        $this->userFieldset = $userFieldset;
        $this->userDetailsFieldset = $userDetailsFieldset;
        parent::__construct('user_form', $options);
    }

    public function init()
    {
        $this->userFieldset->setName('user');
        $this->userFieldset->setUseAsBaseFieldset(true);

        $this->userDetailsFieldset->setName('details');
        $this->userFieldset->add($this->userDetailsFieldset);
        $this->userFieldset->setPriority('details', -5);

        $this->add($this->userFieldset);

        $csrf = new Csrf('user_csrf', [
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
        $validationGroup = [];
        foreach ($this->currentValidationGroups as $key => $value) {
            if($value) {
                $validationGroup[] = $key;
            }
        }
        $this->setValidationGroup(['admin' => $validationGroup]);
    }
}