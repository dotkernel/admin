<?php

declare(strict_types=1);

namespace Admin\Admin\InputFilter;

use Admin\Admin\InputFilter\Input\RolesInput;
use Admin\Admin\InputFilter\Input\StatusInput;
use Admin\App\InputFilter\Input\CsrfInput;
use Admin\App\InputFilter\Input\FirstNameInput;
use Admin\App\InputFilter\Input\IdentityInput;
use Admin\App\InputFilter\Input\LastNameInput;
use Admin\App\InputFilter\Input\PasswordConfirmInput;
use Admin\App\InputFilter\Input\PasswordInput;
use Laminas\InputFilter\InputFilter;

/**
 * @extends InputFilter<object>
 */
class CreateAdminInputFilter extends InputFilter
{
    public function init(): self
    {
        return $this
            ->add(new IdentityInput('identity'))
            ->add(new PasswordInput('password'))
            ->add(new PasswordConfirmInput('passwordConfirm'))
            ->add(new FirstNameInput('firstName', false))
            ->add(new LastNameInput('lastName', false))
            ->add(new StatusInput('status'))
            ->add(new RolesInput('roles'))
            ->add(new CsrfInput('adminCreateCsrf', true));
    }
}
