<?php
/**
 * @see https://github.com/dotkernel/admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/admin/blob/master/LICENSE.md MIT License
 */

namespace Admin\App\Form;

use Admin\App\Messages;
use Zend\Form\Element\Csrf;
use Zend\Form\Form;

/**
 * Class ConfirmDeleteForm
 * @package Admin\App\Form
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
