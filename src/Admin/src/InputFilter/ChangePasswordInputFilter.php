<?php

declare(strict_types=1);

namespace Frontend\Admin\InputFilter;

use Laminas\Filter\StringTrim;
use Laminas\InputFilter\Input;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\Identical;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\StringLength;

/**
 * @extends InputFilter<object>
 */
class ChangePasswordInputFilter extends InputFilter
{
    public function init(): void
    {
        $currentPassword = new Input('currentPassword');
        $currentPassword->setRequired(true);
        $currentPassword->getFilterChain()->attachByName(StringTrim::class);
        $currentPassword->getValidatorChain()->attachByName(NotEmpty::class, [
            'break_chain_on_failure' => true,
            'message'                => '<b>Current Password</b> is required and cannot be empty',
        ]);
        $this->add($currentPassword);

        $password = new Input('password');
        $password->setRequired(true);
        $password->getFilterChain()->attachByName(StringTrim::class);
        $password->getValidatorChain()->attachByName(NotEmpty::class, [
            'break_chain_on_failure' => true,
            'message'                => '<b>Password</b> is required and cannot be empty',
        ]);
        $password->getValidatorChain()->attachByName(StringLength::class, [
            'min'     => 8,
            'max'     => 150,
            'message' => '<b>Password</b> must have between 8 and 150 characters',
        ]);
        $this->add($password);

        $passwordConfirm = new Input('passwordConfirm');
        $passwordConfirm->setRequired(true);
        $passwordConfirm->getFilterChain()->attachByName(StringTrim::class);
        $passwordConfirm->getValidatorChain()->attachByName(NotEmpty::class, [
            'break_chain_on_failure' => true,
            'message'                => '<b>Confirm Password</b> is required and cannot be empty',
        ]);
        $passwordConfirm->getValidatorChain()->attachByName(StringLength::class, [
            'min'     => 8,
            'max'     => 150,
            'message' => '<b>Confirm Password</b> must have between 8 and 150 characters',
        ]);
        $passwordConfirm->getValidatorChain()->attachByName(Identical::class, [
            'token'   => 'password',
            'message' => '<b>Password</b> and <b>Confirm Password</b> do not match',
        ]);
        $this->add($passwordConfirm);
    }
}
