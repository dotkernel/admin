<?php

declare(strict_types=1);

namespace Admin\Admin\InputFilter;

use Admin\App\InputFilter\Input\CsrfInput;
use Admin\App\InputFilter\Input\IdentityInput;
use Admin\App\InputFilter\Input\PasswordInput;
use Core\App\InputFilter\AbstractInputFilter;

/**
 * @phpstan-type LoginDataType array{
 *     identity: non-empty-string,
 *     password: non-empty-string,
 *     loginCsrf: non-empty-string,
 *     submit?: non-empty-string,
 * }
 * @extends AbstractInputFilter<LoginDataType>
 */
class LoginInputFilter extends AbstractInputFilter
{
    public function init(): void
    {
        $this
            ->add(new IdentityInput('identity'))
            ->add(new PasswordInput('password'))
            ->add(new CsrfInput('loginCsrf'));
    }
}
