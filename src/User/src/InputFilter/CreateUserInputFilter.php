<?php

declare(strict_types=1);

namespace Admin\User\InputFilter;

use Admin\App\InputFilter\Input\CsrfInput;
use Admin\App\InputFilter\Input\IdentityInput;
use Admin\App\InputFilter\Input\PasswordConfirmInput;
use Admin\App\InputFilter\Input\PasswordInput;
use Admin\User\InputFilter\Input\RolesInput;
use Admin\User\InputFilter\Input\StatusInput;
use Core\App\InputFilter\AbstractInputFilter;

/**
 * @phpstan-import-type UserDetailDataType from UserDetailInputFilter
 * @phpstan-type CreateUserDataType array{
 *     identity?: non-empty-string,
 *     password?: non-empty-string,
 *     passwordConfirm?: non-empty-string,
 *     status: non-empty-string,
 *     userCreateCsrf: non-empty-string,
 *     submit?: non-empty-string,
 *     detail: UserDetailDataType,
 *     roles: non-empty-string[],
 * }
 * @extends AbstractInputFilter<CreateUserDataType>
 */
class CreateUserInputFilter extends AbstractInputFilter
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
