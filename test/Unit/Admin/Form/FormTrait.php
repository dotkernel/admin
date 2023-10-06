<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\Form;

use Laminas\Form\ElementInterface;
use Laminas\Form\FormInterface;
use Laminas\InputFilter\Input;
use Laminas\InputFilter\InputFilterInterface;

use function count;

trait FormTrait
{
    protected function formWillInstantiate(string $class): void
    {
        $this->assertInstanceOf($class, new $class());
        $this->assertInstanceOf($class, new $class(null, []));
        $this->assertInstanceOf($class, new $class('accountForm'));
        $this->assertInstanceOf($class, new $class('accountForm', []));
    }

    protected function formHasElements(FormInterface $form, array $elements = []): void
    {
        $this->assertEquals(count($elements), $form->count());

        foreach ($elements as $element) {
            $this->assertTrue($form->has($element));
            $this->assertInstanceOf(ElementInterface::class, $form->get($element));
        }
    }

    public function formHasInputFilter(InputFilterInterface $inputFilter, array $inputs = []): void
    {
        $this->assertCount(count($inputs), $inputFilter->getInputs());

        foreach ($inputs as $input) {
            $this->assertTrue($inputFilter->has($input));
            $this->assertInstanceOf(Input::class, $inputFilter->get($input));
        }
    }
}
