<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/10/2016
 * Time: 9:21 PM
 */

namespace Dot\Admin\Admin\Form;

use Zend\Form\Element\Csrf;
use Zend\Form\Form;

/**
 * Class EditAdminForm
 * @package Dot\Admin\Admin\Form
 */
class EditAdminForm extends Form
{
    /**
     * EditAdminForm constructor.
     * @param string $name
     * @param array $options
     */
    public function __construct($name = 'edit_admin_form', array $options = [])
    {
        parent::__construct($name, $options);
    }

    public function init()
    {


        $csrf = new Csrf('admin_add_csrf', [
            'csrf_options' => [
                'timeout' => 3600,
                'message' => 'Add admin form has expired. Please refresh page'
            ]
        ]);
        $this->add($csrf);
    }
}