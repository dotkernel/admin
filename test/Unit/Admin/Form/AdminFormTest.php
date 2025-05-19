<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Form;

use Admin\Admin\Form\CreateAdminForm;
use AdminTest\Unit\UnitTest;
use Laminas\Form\ElementInterface;
use Laminas\InputFilter\BaseInputFilter;
use Laminas\InputFilter\Input;

use function count;

class AdminFormTest extends UnitTest
{
    public function testFormWillInstantiate(): void
    {
        $this->assertSame(CreateAdminForm::class, (new CreateAdminForm())::class);
        $this->assertSame(CreateAdminForm::class, (new CreateAdminForm(null, []))::class);
        $this->assertSame(CreateAdminForm::class, (new CreateAdminForm('form'))::class);
        $this->assertSame(CreateAdminForm::class, (new CreateAdminForm('form', []))::class);
    }

    public function testFormHasElements(): void
    {
        $form = new CreateAdminForm();

        $elements = [
            'identity',
            'password',
            'passwordConfirm',
            'firstName',
            'lastName',
            'status',
            'adminCreateCsrf',
            'submit',
        ];
        foreach ($elements as $element) {
            $this->assertTrue($form->has($element));
            $this->assertContainsOnlyInstancesOf(ElementInterface::class, [$form->get($element)]);
        }
    }

    public function testFormHasInputFilter(): void
    {
        $inputFilter = (new CreateAdminForm())->getInputFilter();

        $inputs = [
            'identity',
            'password',
            'passwordConfirm',
            'firstName',
            'lastName',
            'status',
            'roles',
            'adminCreateCsrf',
        ];

        $this->assertInstanceOf(BaseInputFilter::class, $inputFilter);
        $this->assertCount(count($inputs), $inputFilter->getInputs());

        foreach ($inputs as $input) {
            $this->assertTrue($inputFilter->has($input));
            $this->assertInstanceOf(Input::class, $inputFilter->get($input));
        }
    }
}
