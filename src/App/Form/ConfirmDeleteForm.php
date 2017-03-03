<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vra
 * Date: 11/13/2016
 * Time: 4:22 PM
 */

namespace Admin\App\Form;

use Admin\App\Messages;
use Zend\Form\Element\Csrf;
use Zend\Form\Form;

/**
 * Class DeleteConfirmForm
 * @package Dot\Authentication\Authentication\Form
 */
class ConfirmDeleteForm extends Form
{
    public function __construct()
    {
        parent::__construct('confirmDeleteForm');
        $this->setAttribute('method', 'post');
    }

    public function init()
    {
        $csrf = new Csrf('confirm_delete_csrf', [
            'csrf_options' => [
                'timeout' => 3600,
                'message' => Messages::CSRF_EXPIRED
            ]
        ]);
        $this->add($csrf);
    }
}
