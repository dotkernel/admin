<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Form;

use Admin\Admin\Form\AccountForm;
use AdminTest\Unit\UnitTest;
use Laminas\Form\ElementInterface;
use Laminas\InputFilter\BaseInputFilter;
use Laminas\InputFilter\Input;

use function count;

class AccountFormTest extends UnitTest
{
    public function testFormWillInstantiate(): void
    {
        $this->assertSame(AccountForm::class, (new AccountForm())::class);
        $this->assertSame(AccountForm::class, (new AccountForm(null, []))::class);
        $this->assertSame(AccountForm::class, (new AccountForm('form'))::class);
        $this->assertSame(AccountForm::class, (new AccountForm('form', []))::class);
    }

    public function testFormHasElements(): void
    {
        $form = new AccountForm();

        $elements = ['identity', 'firstName', 'lastName', 'submit', 'accountCsrf'];
        foreach ($elements as $element) {
            $this->assertTrue($form->has($element));
            $this->assertContainsOnlyInstancesOf(ElementInterface::class, [$form->get($element)]);
        }
    }

    public function testFormHasInputFilter(): void
    {
        $inputFilter = (new AccountForm())->getInputFilter();

        $inputs = ['identity', 'firstName', 'lastName', 'accountCsrf'];

        $this->assertInstanceOf(BaseInputFilter::class, $inputFilter);
        $this->assertCount(count($inputs), $inputFilter->getInputs());

        foreach ($inputs as $input) {
            $this->assertTrue($inputFilter->has($input));
            $this->assertInstanceOf(Input::class, $inputFilter->get($input));
        }
    }
}
