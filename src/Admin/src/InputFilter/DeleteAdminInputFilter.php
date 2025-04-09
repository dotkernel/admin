<?php

declare(strict_types=1);

namespace Admin\Admin\InputFilter;

use Admin\Admin\InputFilter\Input\ConfirmationInput;
use Admin\App\InputFilter\Input\CsrfInput;
use Core\App\InputFilter\AbstractInputFilter;

class DeleteAdminInputFilter extends AbstractInputFilter
{
    public function init(): void
    {
        $this
            ->add(new ConfirmationInput('confirmation'))
            ->add(new CsrfInput('adminDeleteCsrf'));
    }
}
