<?php

declare(strict_types=1);

namespace Admin\User\InputFilter;

use Admin\App\InputFilter\Input\CsrfInput;
use Admin\User\InputFilter\Input\ConfirmationInput;
use Core\App\InputFilter\AbstractInputFilter;

/**
 * @phpstan-type DeleteUserDataType array{
 *     confirmation: non-empty-string,
 *     userDeleteCsrf: non-empty-string,
 * }
 * @extends AbstractInputFilter<DeleteUserDataType>
 */
class DeleteUserInputFilter extends AbstractInputFilter
{
    public function init(): self
    {
        return $this
            ->add(new ConfirmationInput('confirmation'))
            ->add(new CsrfInput('userDeleteCsrf'));
    }
}
