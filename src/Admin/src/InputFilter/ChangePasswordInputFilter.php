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
 * Class ChangePasswordInputFilter
 * @package Frontend\Admin\InputFilter
 */
class ChangePasswordInputFilter extends InputFilter
{
    /**
     * @return void
     */
    public function init(): void
    {
        $currentPassword = new Input('currentPassword');
        $currentPassword->setRequired(true);
        $currentPassword->getFilterChain()->attach(StringTrim::class);
        $currentPassword->getValidatorChain()->attachByName(NotEmpty::class, [
            'break_chain_on_failure' => true,
            'message' => '<b>Current Password</b> is required and cannot be empty',
        ]);
        $this->add($currentPassword);

        $password = new Input('password');
        $password->setRequired(true);
        $password->getFilterChain()->attachByName(StringTrim::class);
        $password->getValidatorChain()->attachByName(NotEmpty::class, [
            'break_chain_on_failure' => true,
            'message' => '<b>Password</b> is required and cannot be empty',
        ]);
        $password->getValidatorChain()->attachByName(StringLength::class, [
            'min' => 8,
            'max' => 150,
            'message' => '<b>Password</b> must have between 8 and 150 characters',
        ]);
        $this->add($password);

        $passwordConfirm = new Input('passwordConfirm');
        $passwordConfirm->setRequired(true);
        $passwordConfirm->getFilterChain()->attachByName(StringTrim::class);
        $passwordConfirm->getValidatorChain()->attachByName(Identical::class, [
            'token' => 'password',
            'message' => '<b>Password confirm</b> does not match',
        ]);
        $this->add($passwordConfirm);
    }
}
