<?php

declare(strict_types=1);

namespace Admin\User\InputFilter;

use Admin\App\InputFilter\Input\EmailInput;
use Admin\App\InputFilter\Input\FirstNameInput;
use Admin\App\InputFilter\Input\LastNameInput;
use Core\App\InputFilter\AbstractInputFilter;

class UserDetailInputFilter extends AbstractInputFilter
{
    public function init(): self
    {
        return $this
            ->add(new FirstNameInput('firstName', false))
            ->add(new LastNameInput('lastName', false))
            ->add(new EmailInput('email'));
    }
}
