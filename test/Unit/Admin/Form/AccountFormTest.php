<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Form;

use Admin\Admin\Form\AccountForm;
use AdminTest\Unit\UnitTest;

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
            'submit',
            'accountCsrf',
        ]);
    }

    public function testFormHasInputFilter(): void
    {
        $this->formHasInputFilter((new AccountForm())->getInputFilter(), [
            'identity',
            'firstName',
            'lastName',
            'accountCsrf',
        ]);
    }
}
