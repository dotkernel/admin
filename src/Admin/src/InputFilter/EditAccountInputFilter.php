<?php

declare(strict_types=1);

namespace Admin\Admin\InputFilter;

use Admin\App\InputFilter\Input\CsrfInput;
use Admin\App\InputFilter\Input\FirstNameInput;
use Admin\App\InputFilter\Input\IdentityInput;
use Admin\App\InputFilter\Input\LastNameInput;
use Core\App\InputFilter\AbstractInputFilter;

/**
 * @phpstan-type EditAccountDataType array{
 *     identity: non-empty-string,
 *     firstName?: non-empty-string,
 *     lastName?: non-empty-string,
 *     accountCsrf: non-empty-string,
 * }
 * @extends AbstractInputFilter<EditAccountDataType>
 */
class EditAccountInputFilter extends AbstractInputFilter
{
    public function init(): void
    {
        $this
            ->add(new IdentityInput('identity'))
            ->add(new FirstNameInput('firstName', false))
            ->add(new LastNameInput('lastName', false))
            ->add(new CsrfInput('accountCsrf'));
    }
}
