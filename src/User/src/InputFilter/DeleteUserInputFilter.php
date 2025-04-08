<?php

declare(strict_types=1);

namespace Admin\User\InputFilter;

use Admin\App\InputFilter\Input\CsrfInput;
use Admin\User\InputFilter\Input\ConfirmationInput;
use Laminas\InputFilter\InputFilter;

/**  @extends InputFilter<object> */
class DeleteUserInputFilter extends InputFilter
{
    public function init(): self
    {
        return $this
            ->add(new ConfirmationInput('confirmation'))
            ->add(new CsrfInput('userDeleteCsrf'));
    }
}
