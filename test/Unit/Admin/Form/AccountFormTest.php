<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\Form;

use Frontend\Admin\Form\AccountForm;
use FrontendTest\Unit\UnitTest;

class AccountFormTest extends UnitTest
{
    use FormTrait;

    public function testFormWillInstantiate(): void
    {
        $this->formWillInstantiate(AccountForm::class);
    }

    public function testFormHasElements(): void
    {
        $this->formHasElements(new AccountForm(), [
            'identity',
            'firstName',
            'lastName',
            'account_csrf',
            'submit',
        ]);
    }

    public function testFormHasInputFilter(): void
    {
        $this->formHasInputFilter((new AccountForm())->getInputFilter(), [
            'identity',
            'firstName',
            'lastName',
        ]);
    }
}
