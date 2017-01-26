<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/4/2016
 * Time: 7:38 PM
 */

namespace Dot\Admin\Form\Admin;

use Dot\Admin\Form\EntityBaseForm;

/**
 * Class AdminForm
 * @package Dot\Authentication\Authentication\Form
 */
class AdminForm extends EntityBaseForm
{
    protected $currentValidationGroup = [
        'admin' => [
            'id' => true,
            'username' => true,
            'email' => true,
            'firstName' => true,
            'lastName' => true,
            'password' => true,
            'passwordVerify' => true,
            'role' => true,
            'status' => true
        ]
    ];

    /**
     * AdminForm constructor.
     * @param string $name
     * @param array $options
     */
    public function __construct($name = 'admin_form', array $options = [])
    {
        parent::__construct($name, $options);
    }
}
