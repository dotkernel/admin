<?php

declare(strict_types=1);

namespace Frontend\Admin\InputFilter;

use Frontend\Admin\Entity\Admin;
use Laminas\Filter\StringTrim;
use Laminas\InputFilter\Input;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\Identical;
use Laminas\Validator\InArray;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\Regex;
use Laminas\Validator\StringLength;

/**
 * @extends InputFilter<object>
 */
class EditAdminInputFilter extends InputFilter
{
    public function init(): void
    {
        $identity = new Input('identity');
        $identity->setRequired(true);
        $identity->getFilterChain()->attachByName(StringTrim::class);
        $identity->getValidatorChain()->attachByName(NotEmpty::class, [
            'break_chain_on_failure' => true,
            'message'                => '<b>Identity</b> is required and cannot be empty',
        ]);
        $identity->getValidatorChain()->attachByName(StringLength::class, [
            'min'     => 3,
            'max'     => 100,
            'message' => '<b>Identity</b> must have between 3 and 100 characters',
        ]);
        $identity->getValidatorChain()->attachByName(Regex::class, [
            'pattern' => '/^[a-zA-Z0-9-_.]+$/',
            'message' => '<b>Identity</b> contains invalid characters',
        ]);
        $this->add($identity);

        $password = new Input('password');
        $password->setRequired(false);
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
        $passwordConfirm->setRequired(false);
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

        $firstName = new Input('firstName');
        $firstName->setRequired(false);
        $firstName->getFilterChain()->attachByName(StringTrim::class);
        $firstName->getValidatorChain()->attachByName(NotEmpty::class);
        $firstName->getValidatorChain()->attachByName(StringLength::class, [
            'max'     => 150,
            'message' => '<b>First name</b> must be max 150 characters long.',
        ]);
        $this->add($firstName);

        $lastName = new Input('lastName');
        $lastName->setRequired(false);
        $lastName->getFilterChain()->attachByName(StringTrim::class);
        $lastName->getValidatorChain()->attachByName(NotEmpty::class);
        $lastName->getValidatorChain()->attachByName(StringLength::class, [
            'max'     => 150,
            'message' => '<b>Last name</b> must be max 150 characters long.',
        ]);
        $this->add($lastName);

        $status = new Input('status');
        $status->setRequired(true);
        $status->getFilterChain()->attachByName(StringTrim::class);
        $status->getValidatorChain()->attachByName(InArray::class, [
            'haystack' => [
                Admin::STATUS_ACTIVE,
                Admin::STATUS_INACTIVE,
            ],
        ]);
        $this->add($status);

        $roles = new Input('roles');
        $roles->setRequired(true);
        $roles->getValidatorChain()->attachByName(NotEmpty::class, [
            'break_chain_on_failure' => true,
            'message'                => 'Please select at least one role',
        ]);
        $this->add($roles);
    }
}
