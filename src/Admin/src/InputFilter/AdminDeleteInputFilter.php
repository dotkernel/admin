<?php

declare(strict_types=1);

namespace Frontend\Admin\InputFilter;

use Frontend\App\InputFilter\Input\CsrfInput;
use Laminas\InputFilter\Input;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\InArray;
use Laminas\Validator\NotEmpty;

/**  @extends InputFilter<object> */
class AdminDeleteInputFilter extends InputFilter
{
    public function init(): void
    {
        $confirmation = new Input('confirmation');
        $confirmation->setRequired(true);
        $confirmation->getValidatorChain()->attachByName(NotEmpty::class, [
            'break_chain_on_failure' => true,
            'message'                => 'Please confirm admin deletion.',
        ]);

        $confirmation->getValidatorChain()->attachByName(InArray::class, [
            'haystack'               => [
                'yes',
            ],
            'break_chain_on_failure' => true,
            'message'                => 'Please confirm the admin deletion.',
        ]);

        $this->add($confirmation);

        $this->add(new CsrfInput('adminDeleteCsrf', true));
    }
}
