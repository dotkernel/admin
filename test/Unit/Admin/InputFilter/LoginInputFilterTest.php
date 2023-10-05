<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\InputFilter;

use Frontend\Admin\InputFilter\LoginInputFilter;
use FrontendTest\Unit\UnitTest;

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
        $this->assertArrayHasKey('username', $messages);
        $this->assertIsArray($messages['username']);
        $this->assertArrayHasKey('isEmpty', $messages['username']);
        $this->assertSame('<b>Username</b> is required and cannot be empty', $messages['username']['isEmpty']);

        $inputFilter->setData([
            'username' => null,
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('username', $messages);
        $this->assertIsArray($messages['username']);
        $this->assertArrayHasKey('isEmpty', $messages['username']);
        $this->assertSame('<b>Username</b> is required and cannot be empty', $messages['username']['isEmpty']);

        $inputFilter->setData([
            'username' => '',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('username', $messages);
        $this->assertIsArray($messages['username']);
        $this->assertArrayHasKey('isEmpty', $messages['username']);
        $this->assertSame('<b>Username</b> is required and cannot be empty', $messages['username']['isEmpty']);

        $inputFilter->setData([
            'username' => '   ',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('username', $messages);
        $this->assertIsArray($messages['username']);
        $this->assertArrayHasKey('isEmpty', $messages['username']);
        $this->assertSame('<b>Username</b> is required and cannot be empty', $messages['username']['isEmpty']);
    }

    public function testWillValidatePassword(): void
    {
        $inputFilter = new LoginInputFilter();
        $inputFilter->init();

        $inputFilter->setData([
            'username' => 'username',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('password', $messages);
        $this->assertIsArray($messages['password']);
        $this->assertArrayHasKey('isEmpty', $messages['password']);
        $this->assertSame('<b>Password</b> is required and cannot be empty', $messages['password']['isEmpty']);

        $inputFilter->setData([
            'username' => 'username',
            'password' => null,
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('password', $messages);
        $this->assertIsArray($messages['password']);
        $this->assertArrayHasKey('isEmpty', $messages['password']);
        $this->assertSame('<b>Password</b> is required and cannot be empty', $messages['password']['isEmpty']);

        $inputFilter->setData([
            'username' => 'username',
            'password' => '',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('password', $messages);
        $this->assertIsArray($messages['password']);
        $this->assertArrayHasKey('isEmpty', $messages['password']);
        $this->assertSame('<b>Password</b> is required and cannot be empty', $messages['password']['isEmpty']);

        $inputFilter->setData([
            'username' => 'username',
            'password' => '   ',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('password', $messages);
        $this->assertIsArray($messages['password']);
        $this->assertArrayHasKey('isEmpty', $messages['password']);
        $this->assertSame('<b>Password</b> is required and cannot be empty', $messages['password']['isEmpty']);
    }

    public function testWillAcceptValidData(): void
    {
        $inputFilter = new LoginInputFilter();
        $inputFilter->init();
        $inputFilter->setData([
            'username' => 'username',
            'password' => 'password',
        ]);
        $this->assertTrue($inputFilter->isValid());
    }
}
