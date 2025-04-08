<?php

declare(strict_types=1);

namespace Admin\User\InputFilter;

use Admin\App\InputFilter\Input\CsrfInput;
use Admin\App\InputFilter\Input\ImageInput;
use Laminas\InputFilter\InputFilter;

/**
 * @extends InputFilter<object>
 */
class EditUserAvatarInputFilter extends InputFilter
{
    public function init(): self
    {
        return $this
            ->add(new ImageInput('name'))
            ->add(new CsrfInput('userAvatarEditCsrf'));
    }
}
