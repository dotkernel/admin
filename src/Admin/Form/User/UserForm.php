<?php
/**
 * Created by PhpStorm.
 * User: n3vra
 * Date: 11/20/2016
 * Time: 4:49 AM
 */

namespace Dot\Admin\Form\User;

use Dot\Admin\Form\EntityBaseForm;

/**
 * Class UserForm
 * @package Dot\Authentication\User\Form
 */
class UserForm extends EntityBaseForm
{
    protected $currentValidationGroup = [
        'user' => [
            'id' => true,
            'username' => true,
            'email' => true,
            'details' => [
                'firstName' => true,
                'lastName' => true,
                'address' => true,
                'phone' => true
            ],
            'password' => true,
            'passwordVerify' => true,
            'role' => true,
            'status' => true
        ]
    ];

    public function __construct($name = 'user_form', $options = [])
    {
        parent::__construct($name, $options);
    }
}
