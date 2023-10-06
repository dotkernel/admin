<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\Form;

use Frontend\Admin\Form\ChangePasswordForm;
use FrontendTest\Unit\UnitTest;

class ChangePasswordFormTest extends UnitTest
{
    use FormTrait;

    public function testFormWillInstantiate(): void
    {
        $this->formWillInstantiate(ChangePasswordForm::class);
    }

    public function testFormHasElements(): void
    {
        $this->formHasElements(new ChangePasswordForm(), [
            'currentPassword',
            'password',
            'passwordConfirm',
            'change_password_csrf',
            'submit',
        ]);
    }

    public function testFormHasInputFilter(): void
    {
        $this->formHasInputFilter((new ChangePasswordForm())->getInputFilter(), [
            'currentPassword',
            'password',
            'passwordConfirm',
        ]);
    }
}
