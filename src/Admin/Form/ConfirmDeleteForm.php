<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vra
 * Date: 11/13/2016
 * Time: 4:22 PM
 */

namespace Dot\Admin\Form;

use Zend\Form\Element\Csrf;
use Zend\Form\Form;

/**
 * Class DeleteConfirmForm
 * @package Dot\Authentication\Authentication\Form
 */
class ConfirmDeleteForm extends Form
{
    public function __construct($name = 'delete_confirm', array $options = [])
    {
        parent::__construct($name, $options);
    }

    public function init()
    {
        $csrf = new Csrf('delete_confirm_csrf', [
            'csrf_options' => [
                'timeout' => 3600,
                'message' => 'The form used to make the request has expired. Please try again now'
            ]
        ]);
        $this->add($csrf);
    }
}