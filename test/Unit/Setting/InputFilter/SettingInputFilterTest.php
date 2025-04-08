<?php

declare(strict_types=1);

namespace AdminTest\Unit\Setting\InputFilter;

use Admin\Setting\InputFilter\CreateSettingInputFilter;
use AdminTest\Common\TestCase;
use Core\App\Message;

use function sprintf;

class SettingInputFilterTest extends TestCase
{
    public function testWillValidateIdentifier(): void
    {
        $inputFilter = new CreateSettingInputFilter();
        $inputFilter->init();

        $inputFilter->setData([]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('identifier', $messages);
        $this->assertIsArray($messages['identifier']);
        $this->assertArrayHasKey('isEmpty', $messages['identifier']);
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['identifier']['isEmpty']);

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
