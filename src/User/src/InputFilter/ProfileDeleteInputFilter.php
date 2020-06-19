<?php

/**
 * @see https://github.com/dotkernel/frontend/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/frontend/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace Frontend\User\InputFilter;

use Laminas\InputFilter\InputFilter;

/**
 * Class ProfileDeleteInputFilter
 * @package Frontend\Admin\InputFilter
 */
class ProfileDeleteInputFilter extends InputFilter
{
    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'isDeleted',
            'required' => true,
            'validators' => [
                [
                    'name' => 'InArray',
                    'options' => [
                        'haystack' => [
                            'yes',
                        ],
                        'message' => 'You must check delete option.',
                    ],
                ]
            ]
        ]);
    }
}
