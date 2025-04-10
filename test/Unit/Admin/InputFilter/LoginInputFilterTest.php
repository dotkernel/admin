<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\InputFilter;

use Admin\Admin\InputFilter\LoginInputFilter;
use AdminTest\Unit\UnitTest;
use Core\App\Message;
use Laminas\Session\Container;
use Laminas\Session\Validator\Csrf;

class LoginInputFilterTest extends UnitTest
{
    public function testWillValidateUsername(): void
    {
        $inputFilter = new LoginInputFilter();
        $inputFilter->init();

        $inputFilter->setData([]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('identity', $messages);
        $this->assertIsArray($messages['identity']);
        $this->assertArrayHasKey('isEmpty', $messages['identity']);
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['identity']['isEmpty']);

        $inputFilter->setData([
            'identity' => null,
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('identity', $messages);
        $this->assertIsArray($messages['identity']);
        $this->assertArrayHasKey('isEmpty', $messages['identity']);
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['identity']['isEmpty']);

        $inputFilter->setData([
            'identity' => '',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('identity', $messages);
        $this->assertIsArray($messages['identity']);
        $this->assertArrayHasKey('isEmpty', $messages['identity']);
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['identity']['isEmpty']);

        $inputFilter->setData([
            'identity' => '   ',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('identity', $messages);
        $this->assertIsArray($messages['identity']);
        $this->assertArrayHasKey('isEmpty', $messages['identity']);
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['identity']['isEmpty']);
    }

    public function testWillValidatePassword(): void
    {
        $inputFilter = new LoginInputFilter();
        $inputFilter->init();

        $inputFilter->setData([
            'identity' => 'identity',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('password', $messages);
        $this->assertIsArray($messages['password']);
        $this->assertArrayHasKey('isEmpty', $messages['password']);
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['password']['isEmpty']);

        $inputFilter->setData([
            'identity' => 'identity',
            'password' => null,
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('password', $messages);
        $this->assertIsArray($messages['password']);
        $this->assertArrayHasKey('isEmpty', $messages['password']);
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['password']['isEmpty']);

        $inputFilter->setData([
            'identity' => 'identity',
            'password' => '',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('password', $messages);
        $this->assertIsArray($messages['password']);
        $this->assertArrayHasKey('isEmpty', $messages['password']);
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['password']['isEmpty']);

        $inputFilter->setData([
            'identity' => 'identity',
            'password' => '   ',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('password', $messages);
        $this->assertIsArray($messages['password']);
        $this->assertArrayHasKey('isEmpty', $messages['password']);
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['password']['isEmpty']);
    }

    public function testWillAcceptValidData(): void
    {
        $hash = (new Csrf(['session' => new Container()]))->getHash();

        $inputFilter = new LoginInputFilter();
        $inputFilter->init();
        $inputFilter->setData([
            'identity'  => 'identity',
            'password'  => 'password',
            'loginCsrf' => $hash,
        ]);
        $this->assertTrue($inputFilter->isValid());
    }
}
