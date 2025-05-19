<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Form;

use Admin\Admin\Form\ChangePasswordForm;
use AdminTest\Unit\UnitTest;
use Laminas\Form\ElementInterface;
use Laminas\InputFilter\BaseInputFilter;
use Laminas\InputFilter\Input;

use function count;

class ChangePasswordFormTest extends UnitTest
{
    public function testFormWillInstantiate(): void
    {
        $this->assertSame(ChangePasswordForm::class, (new ChangePasswordForm())::class);
        $this->assertSame(ChangePasswordForm::class, (new ChangePasswordForm(null, []))::class);
        $this->assertSame(ChangePasswordForm::class, (new ChangePasswordForm('form'))::class);
        $this->assertSame(ChangePasswordForm::class, (new ChangePasswordForm('form', []))::class);
    }

    public function testFormHasElements(): void
    {
        $form = new ChangePasswordForm();

        $elements = ['currentPassword', 'password', 'passwordConfirm', 'submit', 'changePasswordCsrf'];
        foreach ($elements as $element) {
            $this->assertTrue($form->has($element));
            $this->assertContainsOnlyInstancesOf(ElementInterface::class, [$form->get($element)]);
        }
    }

    public function testFormHasInputFilter(): void
    {
        $inputFilter = (new ChangePasswordForm())->getInputFilter();

        $inputs = ['currentPassword', 'password', 'passwordConfirm', 'changePasswordCsrf'];

        $this->assertInstanceOf(BaseInputFilter::class, $inputFilter);
        $this->assertCount(count($inputs), $inputFilter->getInputs());

        foreach ($inputs as $input) {
            $this->assertTrue($inputFilter->has($input));
            $this->assertInstanceOf(Input::class, $inputFilter->get($input));
        }
    }
}
