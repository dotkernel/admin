<?php

declare(strict_types=1);

namespace Frontend\User\InputFilter;

use Laminas\InputFilter\InputFilter;

/**
 * Class RoleInputFilter
 * @package Frontend\User\InputFilter
 */
class RoleInputFilter extends InputFilter
{
    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'uuid',
            'required' => false,
            'filters' => [],
            'validators' => []
        ]);
    }
}
