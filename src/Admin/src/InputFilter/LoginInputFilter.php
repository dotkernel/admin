<?php

declare(strict_types=1);

namespace Admin\Admin\InputFilter;

use Admin\App\InputFilter\Input\CsrfInput;
use Admin\App\InputFilter\Input\IdentityInput;
use Admin\App\InputFilter\Input\PasswordInput;
use Laminas\InputFilter\InputFilter;

/**
 * @extends InputFilter<object>
 */
class LoginInputFilter extends InputFilter
{
    public function init(): void
    {
        $this
            ->add(new IdentityInput('identity'))
            ->add(new PasswordInput('password'))
            ->add(new CsrfInput('loginCsrf'));
    }
}
