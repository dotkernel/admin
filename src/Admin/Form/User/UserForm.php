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
use Zend\Form\FieldsetInterface;
use Zend\Form\Form;
use Zend\Form\FormInterface;

/**
 * Class UserForm
 * @package Dot\Authentication\User\Form
 */
class UserForm extends Form
{
    /** @var  Fieldset */
    protected $userFieldset;

    /** @var  Fieldset */
    protected $userDetailsFieldset;

    protected $currentValidationGroup = [
        'id' => true, 'username' => true, 'email' => true,
        'details' => ['firstName' => true, 'lastName' => true, 'address' => true, 'phone' => true],
        'password' => true, 'passwordVerify' => true, 'role' => true, 'status' => true
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
        $this->currentValidationGroup['username'] = false;
    }

    public function removeEmailValidation()
    {
        $this->currentValidationGroup['email'] = false;
    }

    public function resetValidationGroup()
    {
        foreach ($this->currentValidationGroup as $key => $value) {
            $this->currentValidationGroup[$key] = true;
        }
        $this->setValidationGroup(FormInterface::VALIDATE_ALL);
    }

    public function applyValidationGroup()
    {
        $validationGroup = $this->getActiveValidationGroup($this->currentValidationGroup, $this->getBaseFieldset());
        $this->setValidationGroup(['user' => $validationGroup]);
    }

    public function getActiveValidationGroup($groups, FieldsetInterface $prevElement)
    {
        $validationGroup = [];
        foreach ($groups as $key => $value) {
            if(is_array($value)) {
                if($prevElement->has($key)) {
                    $validationGroup[$key] = $this->getActiveValidationGroup($value, $prevElement->get($key));
                }
            }
            elseif($value === true && $prevElement->has($key)) {
                $validationGroup[] = $key;
            }
        }
        return $validationGroup;
    }
}