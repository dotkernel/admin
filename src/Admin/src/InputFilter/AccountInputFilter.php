<?php

declare(strict_types=1);

namespace Frontend\Admin\InputFilter;

use Laminas\Filter\StringTrim;
use Laminas\InputFilter\Input;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\Regex;
use Laminas\Validator\StringLength;

/**
 * Class AccountInputFilter
 * @package Frontend\Admin\InputFilter
 */
class AccountInputFilter extends InputFilter
{
    public function init()
    {
        parent::init();

        $identity = new Input('identity');
        $identity->setRequired(true);
        $identity->getFilterChain()->attachByName(StringTrim::class);
        $identity->getValidatorChain()->attachByName(NotEmpty::class, [
            'break_chain_on_failure' => true,
            'message' => '<b>Identity</b> cannot be empty',
        ]);
        $identity->getValidatorChain()->attachByName(StringLength::class, [
            'break_chain_on_failure' => true,
            'min' => 3,
            'max' => 100,
            'message' => '<b>Identity</b> must have between 3 and 100 characters',
        ]);
        $identity->getValidatorChain()->attachByName(Regex::class, [
            'break_chain_on_failure' => true,
            'pattern' => '/^[a-zA-Z0-9-_.]+$/',
            'message' => '<b>Identity</b> contains invalid characters',
        ]);

        $this->add($identity);

        $firstName = new Input('firstName');
        $firstName->setRequired(false);
        $firstName->getFilterChain()->attachByName(StringTrim::class);
        $firstName->getValidatorChain()->attachByName(NotEmpty::class);
        $firstName->getValidatorChain()->attachByName(StringLength::class, [
            'max' => 150,
            'message' => '<b>First name</b> must be max 150 characters long.',
        ]);

        $this->add($firstName);

        $lastName = new Input('lastName');
        $lastName->setRequired(false);
        $lastName->getFilterChain()->attachByName(StringTrim::class);
        $lastName->getValidatorChain()->attachByName(NotEmpty::class);
        $lastName->getValidatorChain()->attachByName(StringLength::class, [
            'max' => 150,
            'message' => '<b>Last name</b> must be max 150 characters long.',
        ]);

        $this->add($lastName);
    }
}
