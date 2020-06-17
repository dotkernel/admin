<?php

/**
 * @see https://github.com/dotkernel/frontend/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/frontend/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace Frontend\User\Fieldset;

use Frontend\User\Entity\UserDetail;
use Laminas\Form\Element\Text;
use Laminas\Form\Fieldset;

/**
 * Class ResponseFieldset
 * @package Frontend\App\Form
 */
class UserDetailFieldset extends Fieldset
{
    /**
     * ResponseFieldset constructor.
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name = 'detail', $options);
    }

    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'firstName',
            'options' => [
                'label' => 'First Name'
            ],
            'attributes' => [
                'placeholder' => 'First Name...',
            ],
            'type' => Text::class
        ]);

        $this->add([
            'name' => 'lastName',
            'options' => [
                'label' => 'Last Name'
            ],
            'attributes' => [
                'placeholder' => 'Last Name...',
            ],
            'type' => Text::class
        ]);
    }
}
