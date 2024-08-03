<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Form;

use Admin\Admin\Form\LoginForm;
use AdminTest\Unit\UnitTest;

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
            'loginCsrf',
        ]);
    }

    public function testFormHasInputFilter(): void
    {
        $this->formHasInputFilter((new LoginForm())->getInputFilter(), [
            'username',
            'password',
            'loginCsrf',
        ]);
    }
}
