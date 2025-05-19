<?php

declare(strict_types=1);

namespace Admin\User\InputFilter;

use Admin\App\InputFilter\Input\CsrfInput;
use Admin\App\InputFilter\Input\PasswordConfirmInput;
use Admin\App\InputFilter\Input\PasswordInput;
use Admin\User\InputFilter\Input\RolesInput;
use Admin\User\InputFilter\Input\StatusInput;
use Core\App\InputFilter\AbstractInputFilter;

/**
 * @phpstan-import-type UserDetailDataType from UserDetailInputFilter
 * @phpstan-type EditUserDataType array{
 *     password?: non-empty-string,
 *     passwordConfirm?: non-empty-string,
 *     status: non-empty-string,
 *     userEditCsrf: non-empty-string,
 *     submit?: non-empty-string,
 *     detail: UserDetailDataType,
 *     roles: non-empty-string[],
 * }
 * @extends AbstractInputFilter<EditUserDataType>
 */
class EditUserInputFilter extends AbstractInputFilter
{
    public function init(): self
    {
        return $this
            ->add(new PasswordInput('password', false))
            ->add(new PasswordConfirmInput('passwordConfirm', false))
            ->add(new StatusInput('status'))
            ->add(new RolesInput('roles'))
            ->add(new CsrfInput('userEditCsrf'))
            ->add((new UserDetailInputFilter())->init(), 'detail');
    }
}
