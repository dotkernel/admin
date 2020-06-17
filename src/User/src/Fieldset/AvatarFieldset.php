<?php

/**
 * @see https://github.com/dotkernel/frontend/ for the canonical source repository
 * @copyright Copyright (c) 2020 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/frontend/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace Frontend\User\Fieldset;

use Laminas\Form\Element\File;
use Laminas\Form\Fieldset;

/**
 * Class AvatarFieldset
 * @package Frontend\App\Form
 */
class AvatarFieldset extends Fieldset
{
    /**
     * ResponseFieldset constructor.
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name = 'avatar', $options);
    }

    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'image',
            'attributes' => [
                'class' => 'img-input',
                'name' => 'image',
            ],
            'type' => File::class
        ]);
    }
}
