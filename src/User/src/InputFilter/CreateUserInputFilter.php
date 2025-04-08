<?php

declare(strict_types=1);

namespace Admin\User\InputFilter;

use Admin\App\InputFilter\Input\CsrfInput;
use Admin\App\InputFilter\Input\IdentityInput;
use Admin\App\InputFilter\Input\PasswordConfirmInput;
use Admin\App\InputFilter\Input\PasswordInput;
use Admin\User\InputFilter\Input\RolesInput;
use Admin\User\InputFilter\Input\StatusInput;
use Laminas\InputFilter\InputFilter;

/**
 * @extends InputFilter<object>
 */
class CreateUserInputFilter extends InputFilter
{
    public function init(): self
    {
        return $this
            ->add((new UserDetailInputFilter())->init(), 'detail')
            ->add(new IdentityInput('identity'))
            ->add(new PasswordInput('password'))
            ->add(new PasswordConfirmInput('passwordConfirm'))
            ->add(new StatusInput('status'))
            ->add(new RolesInput('roles'))
            ->add(new CsrfInput('userCreateCsrf'));
    }
}
