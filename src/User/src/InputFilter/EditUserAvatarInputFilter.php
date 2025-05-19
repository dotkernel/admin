<?php

declare(strict_types=1);

namespace Admin\User\InputFilter;

use Admin\App\InputFilter\Input\CsrfInput;
use Admin\App\InputFilter\Input\ImageInput;
use Core\App\InputFilter\AbstractInputFilter;

/**
 * @phpstan-type EditUserAvatarDataType array{
 *     name: non-empty-string,
 *     userAvatarEditCsrf: non-empty-string,
 * }
 * @extends AbstractInputFilter<EditUserAvatarDataType>
 */
class EditUserAvatarInputFilter extends AbstractInputFilter
{
    public function init(): self
    {
        return $this
            ->add(new ImageInput('name'))
            ->add(new CsrfInput('userAvatarEditCsrf'));
    }
}
