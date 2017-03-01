<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vra
 * Date: 11/13/2016
 * Time: 4:22 PM
 */

namespace Dot\Admin\Form;

use Admin\App\Messages;
use Zend\Form\Element\Csrf;
use Zend\Form\Form;

/**
 * Class DeleteConfirmForm
 * @package Dot\Authentication\Authentication\Form
 */
class ConfirmDeleteForm extends Form
{
    public function __construct($name = 'deleteConfirmForm', array $options = [])
    {
        parent::__construct($name, $options);
        $this->setAttribute('method', 'post');
    }

    public function init()
    {
        $csrf = new Csrf('delete_confirm_csrf', [
            'csrf_options' => [
                'timeout' => 3600,
                'message' => Messages::CSRF_EXPIRED
            ]
        ]);
        $this->add($csrf);
    }
}
