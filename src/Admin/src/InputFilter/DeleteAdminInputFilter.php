<?php

declare(strict_types=1);

namespace Admin\Admin\InputFilter;

use Admin\Admin\InputFilter\Input\ConfirmationInput;
use Admin\App\InputFilter\Input\CsrfInput;
use Laminas\InputFilter\InputFilter;

/**
 * @extends InputFilter<object>
 */
class DeleteAdminInputFilter extends InputFilter
{
    public function init(): void
    {
        $this
            ->add(new ConfirmationInput('confirmation'))
            ->add(new CsrfInput('adminDeleteCsrf'));
    }
}
