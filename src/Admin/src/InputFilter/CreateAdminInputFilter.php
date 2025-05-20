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
use Core\App\InputFilter\AbstractInputFilter;

/**
 * @phpstan-type CreateAdminDataType array{
 *     identity?: non-empty-string,
 *     password?: non-empty-string,
 *     passwordConfirm?: non-empty-string,
 *     firstName?: non-empty-string,
 *     lastName?: non-empty-string,
 *     status: non-empty-string,
 *     adminCreateCsrf: non-empty-string,
 *     submit?: non-empty-string,
 *     roles: non-empty-string[],
 * }
 * @extends AbstractInputFilter<CreateAdminDataType>
 */
class CreateAdminInputFilter extends AbstractInputFilter
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
