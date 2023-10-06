<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\Form;

use Frontend\Admin\Form\AdminForm;
use Frontend\Admin\InputFilter\AdminInputFilter;
use Frontend\Admin\InputFilter\EditAdminInputFilter;
use FrontendTest\Unit\UnitTest;

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
        ]);
    }

    public function testFormWillSetDifferentInputFilter(): void
    {
        $form = new AdminForm();

        $oldInputFilter = $form->getInputFilter();
        $this->assertInstanceOf(AdminInputFilter::class, $oldInputFilter);

        $customInputFilter = new EditAdminInputFilter();
        $form->setDifferentInputFilter($customInputFilter);

        $newInputFilter = $form->getInputFilter();
        $this->assertInstanceOf(EditAdminInputFilter::class, $newInputFilter);

        $this->assertNotSame($oldInputFilter, $newInputFilter);
    }
}
