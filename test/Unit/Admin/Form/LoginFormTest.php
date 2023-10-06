<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\Form;

use Frontend\Admin\Form\LoginForm;
use FrontendTest\Unit\UnitTest;

class LoginFormTest extends UnitTest
{
    use FormTrait;

    public function testFormWillInstantiate(): void
    {
        $this->formWillInstantiate(LoginForm::class);
    }

    public function testFormHasElements(): void
    {
        $this->formHasElements(new LoginForm(), [
            'username',
            'password',
            'submit',
        ]);
    }

    public function testFormHasInputFilter(): void
    {
        $this->formHasInputFilter((new LoginForm())->getInputFilter(), [
            'username',
            'password',
        ]);
    }
}
