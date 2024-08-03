<?php

declare(strict_types=1);

namespace AdminTest\Unit\Setting\InputFilter;

use Admin\App\Message;
use Admin\Setting\InputFilter\SettingInputFilter;
use AdminTest\Common\TestCase;

use function sprintf;

class SettingInputFilterTest extends TestCase
{
    public function testWillValidateIdentifier(): void
    {
        $inputFilter = new SettingInputFilter();
        $inputFilter->init();

        $inputFilter->setData([]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('identifier', $messages);
        $this->assertIsArray($messages['identifier']);
        $this->assertArrayHasKey('isEmpty', $messages['identifier']);
        $this->assertSame('<b>Identifier</b> is required and cannot be empty.', $messages['identifier']['isEmpty']);

        $inputFilter->setData(['identifier' => 'test']);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('identifier', $messages);
        $this->assertIsArray($messages['identifier']);
        $this->assertArrayHasKey('notInArray', $messages['identifier']);
        $this->assertSame(sprintf(Message::INVALID_VALUE, 'identifier'), $messages['identifier']['notInArray']);
    }
}
