<?php

declare(strict_types=1);

namespace Admin\Admin\InputFilter;

use Admin\Admin\InputFilter\Input\CurrentPasswordInput;
use Admin\App\InputFilter\Input\CsrfInput;
use Admin\App\InputFilter\Input\PasswordConfirmInput;
use Admin\App\InputFilter\Input\PasswordInput;
use Core\App\InputFilter\AbstractInputFilter;

class ChangePasswordInputFilter extends AbstractInputFilter
{
    public function init(): void
    {
        $this
            ->add(new CurrentPasswordInput('currentPassword'))
            ->add(new PasswordInput('password'))
            ->add(new PasswordConfirmInput('passwordConfirm'))
            ->add(new CsrfInput('changePasswordCsrf'));
    }
}
