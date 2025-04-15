<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Form;

use Admin\Admin\Form\CreateAdminForm;
use AdminTest\Unit\UnitTest;

class AdminFormTest extends UnitTest
{
    use FormTrait;

    public function testFormWillInstantiate(): void
    {
        $this->formWillInstantiate(CreateAdminForm::class);
    }

    public function testFormHasElements(): void
    {
        $this->formHasElements(new CreateAdminForm(), [
            'identity',
            'password',
            'passwordConfirm',
            'firstName',
            'lastName',
            'status',
            'adminCreateCsrf',
            'submit',
        ]);
    }

    public function testFormHasInputFilter(): void
    {
        $this->formHasInputFilter((new CreateAdminForm())->getInputFilter(), [
            'identity',
            'password',
            'passwordConfirm',
            'firstName',
            'lastName',
            'status',
            'roles',
            'adminCreateCsrf',
        ]);
    }
}
