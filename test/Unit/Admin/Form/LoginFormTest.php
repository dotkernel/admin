<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Form;

use Admin\Admin\Form\LoginForm;
use AdminTest\Unit\UnitTest;
use Laminas\Form\ElementInterface;
use Laminas\InputFilter\BaseInputFilter;
use Laminas\InputFilter\Input;

use function count;

class LoginFormTest extends UnitTest
{
    public function testFormWillInstantiate(): void
    {
        $this->assertSame(LoginForm::class, (new LoginForm())::class);
        $this->assertSame(LoginForm::class, (new LoginForm(null, []))::class);
        $this->assertSame(LoginForm::class, (new LoginForm('form'))::class);
        $this->assertSame(LoginForm::class, (new LoginForm('form', []))::class);
    }

    public function testFormHasElements(): void
    {
        $form = new LoginForm();

        $elements = ['identity', 'password', 'loginCsrf', 'submit'];
        foreach ($elements as $element) {
            $this->assertTrue($form->has($element));
            $this->assertContainsOnlyInstancesOf(ElementInterface::class, [$form->get($element)]);
        }
    }

    public function testFormHasInputFilter(): void
    {
        $inputFilter = (new LoginForm())->getInputFilter();

        $inputs = ['identity', 'password', 'loginCsrf'];

        $this->assertInstanceOf(BaseInputFilter::class, $inputFilter);
        $this->assertCount(count($inputs), $inputFilter->getInputs());

        foreach ($inputs as $input) {
            $this->assertTrue($inputFilter->has($input));
            $this->assertInstanceOf(Input::class, $inputFilter->get($input));
        }
    }
}
