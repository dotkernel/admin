<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Form;

use Admin\Admin\Form\AdminForm;
use Admin\Admin\InputFilter\AdminInputFilter;
use Admin\Admin\InputFilter\EditAdminInputFilter;
use AdminTest\Unit\UnitTest;

class AdminFormTest extends UnitTest
{
    use FormTrait;

    public function testFormWillInstantiate(): void
    {
        $this->formWillInstantiate(AdminForm::class);
    }

    public function testFormHasElements(): void
    {
        $this->formHasElements(new AdminForm(), [
            'identity',
            'password',
            'passwordConfirm',
            'firstName',
            'lastName',
            'status',
            'adminManageCsrf',
        ]);
    }

    public function testFormHasInputFilter(): void
    {
        $this->formHasInputFilter((new AdminForm())->getInputFilter(), [
            'identity',
            'password',
            'passwordConfirm',
            'firstName',
            'lastName',
            'status',
            'roles',
            'adminManageCsrf',
        ]);
    }

    public function testFormWillSetDifferentInputFilter(): void
    {
        $form = new AdminForm();

        $oldInputFilter = $form->getInputFilter();
        $this->assertInstanceOf(AdminInputFilter::class, $oldInputFilter);

        $customInputFilter = new EditAdminInputFilter();
        $form->setInputFilter($customInputFilter);

        $newInputFilter = $form->getInputFilter();
        $this->assertInstanceOf(EditAdminInputFilter::class, $newInputFilter);
    }
}
