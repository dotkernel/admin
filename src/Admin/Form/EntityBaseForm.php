<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 1/26/2017
 * Time: 8:00 PM
 */

namespace Dot\Admin\Form;

use Zend\Form\Element\Csrf;
use Zend\Form\ElementInterface;
use Zend\Form\FieldsetInterface;
use Zend\Form\Form;
use Zend\Form\FormInterface;

/**
 * Class EntityBaseForm
 * @package Dot\Admin\Form
 */
class EntityBaseForm extends Form
{
    protected $currentValidationGroup = [];

    public function init()
    {
        $csrf = new Csrf('user_csrf', [
            'csrf_options' => [
                'timeout' => 3600,
                'message' => 'The form used to make the request has expired. Please try again now'
            ]
        ]);
        $this->add($csrf);
    }

    /**
     * @param $inputName
     * @param bool $flag
     */
    public function setValidationForInput($inputName, $flag)
    {
        $parts = explode('.', $inputName);
        $lastKey = array_pop($parts);

        $val = &$this->currentValidationGroup;
        foreach ($parts as $part) {
            $val = &$val[$part];
        }
        $val[$lastKey] = $flag;
    }

    /**
     * @param $group
     */
    public function resetValidationGroup(&$group)
    {
        foreach ($group as $key => $value) {
            if (is_array($value)) {
                $this->resetValidationGroup($value);
            } else {
                $group[$key] = true;
            }
        }
        $this->setValidationGroup(FormInterface::VALIDATE_ALL);
    }

    /**
     * Set current validation group to the form
     */
    public function applyValidationGroup()
    {
        $validationGroup = $this->getActiveValidationGroup($this->currentValidationGroup, $this);
        $this->setValidationGroup($validationGroup);
    }

    /**
     * @param $groups
     * @param ElementInterface $prevElement
     * @return array
     */
    public function getActiveValidationGroup($groups, ElementInterface $prevElement)
    {
        $validationGroup = [];
        foreach ($groups as $key => $value) {
            if (is_array($value) &&
                ($prevElement instanceof FieldsetInterface || $prevElement instanceof FormInterface)) {
                if ($prevElement->has($key)) {
                    $validationGroup[$key] = $this->getActiveValidationGroup($value, $prevElement->get($key));
                }
            } elseif ($value === true && $prevElement->has($key)) {
                $validationGroup[] = $key;
            }
        }
        return $validationGroup;
    }
}
