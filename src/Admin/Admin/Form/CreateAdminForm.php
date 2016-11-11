<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/4/2016
 * Time: 7:38 PM
 */

namespace Dot\Admin\Admin\Form;

use Zend\Form\Element\Csrf;
use Zend\Form\Fieldset;
use Zend\Form\Form;

/**
 * Class AdminForm
 * @package Dot\Admin\Admin\Form
 */
class CreateAdminForm extends Form
{
    /** @var  Fieldset */
    protected $adminFieldset;

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

        $csrf = new Csrf('admin_add_csrf', [
            'csrf_options' => [
                'timeout' => 3600,
                'message' => 'Add admin form has expired. Please refresh page'
            ]
        ]);
        $this->add($csrf);
    }
}