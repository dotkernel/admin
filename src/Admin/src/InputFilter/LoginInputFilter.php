<?php

declare(strict_types=1);

namespace Frontend\Admin\InputFilter;

use Laminas\Filter\StringTrim;
use Laminas\InputFilter\Input;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\NotEmpty;

/**
 * @extends InputFilter<object>
 */
class LoginInputFilter extends InputFilter
{
    public function init(): void
    {
        $username = new Input('username');
        $username->setRequired(true);
        $username->getFilterChain()->attachByName(StringTrim::class);
        $username->getValidatorChain()->attachByName(NotEmpty::class, [
            'break_chain_on_failure' => true,
            'message'                => '<b>Username</b> is required and cannot be empty',
        ]);
        $this->add($username);

        $password = new Input('password');
        $password->setRequired(true);
        $password->getFilterChain()->attachByName(StringTrim::class);
        $password->getValidatorChain()->attachByName(NotEmpty::class, [
            'break_chain_on_failure' => true,
            'message'                => '<b>Password</b> is required and cannot be empty',
        ]);
        $this->add($password);
    }
}
