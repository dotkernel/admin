<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\InputFilter;

use Frontend\Admin\InputFilter\ChangePasswordInputFilter;
use FrontendTest\Unit\UnitTest;

use function str_repeat;

class ChangePasswordInputFilterTest extends UnitTest
{
    public function testWillValidateCurrentPassword(): void
    {
        $inputFilter = new ChangePasswordInputFilter();
        $inputFilter->init();

        $inputFilter->setData([]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('currentPassword', $messages);
        $this->assertIsArray($messages['currentPassword']);
        $this->assertArrayHasKey('isEmpty', $messages['currentPassword']);
        $this->assertSame(
            '<b>Current Password</b> is required and cannot be empty',
            $messages['currentPassword']['isEmpty']
        );

        $inputFilter->setData([
            'currentPassword' => null,
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('currentPassword', $messages);
        $this->assertIsArray($messages['currentPassword']);
        $this->assertArrayHasKey('isEmpty', $messages['currentPassword']);
        $this->assertSame(
            '<b>Current Password</b> is required and cannot be empty',
            $messages['currentPassword']['isEmpty']
        );

        $inputFilter->setData([
            'currentPassword' => '',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('currentPassword', $messages);
        $this->assertIsArray($messages['currentPassword']);
        $this->assertArrayHasKey('isEmpty', $messages['currentPassword']);
        $this->assertSame(
            '<b>Current Password</b> is required and cannot be empty',
            $messages['currentPassword']['isEmpty']
        );

        $inputFilter->setData([
            'currentPassword' => '   ',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('currentPassword', $messages);
        $this->assertIsArray($messages['currentPassword']);
        $this->assertArrayHasKey('isEmpty', $messages['currentPassword']);
        $this->assertSame(
            '<b>Current Password</b> is required and cannot be empty',
            $messages['currentPassword']['isEmpty']
        );
    }

    public function testWillValidatePassword(): void
    {
        $inputFilter = new ChangePasswordInputFilter();
        $inputFilter->init();

        $inputFilter->setData([
            'currentPassword' => 'password',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('password', $messages);
        $this->assertIsArray($messages['password']);
        $this->assertArrayHasKey('isEmpty', $messages['password']);
        $this->assertSame(
            '<b>Password</b> is required and cannot be empty',
            $messages['password']['isEmpty']
        );

        $inputFilter->setData([
            'currentPassword' => 'password',
            'password'        => null,
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('password', $messages);
        $this->assertIsArray($messages['password']);
        $this->assertArrayHasKey('isEmpty', $messages['password']);
        $this->assertSame(
            '<b>Password</b> is required and cannot be empty',
            $messages['password']['isEmpty']
        );

        $inputFilter->setData([
            'currentPassword' => 'password',
            'password'        => '',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('password', $messages);
        $this->assertIsArray($messages['password']);
        $this->assertArrayHasKey('isEmpty', $messages['password']);
        $this->assertSame(
            '<b>Password</b> is required and cannot be empty',
            $messages['password']['isEmpty']
        );

        $inputFilter->setData([
            'currentPassword' => 'password',
            'password'        => '   ',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('password', $messages);
        $this->assertIsArray($messages['password']);
        $this->assertArrayHasKey('isEmpty', $messages['password']);
        $this->assertSame(
            '<b>Password</b> is required and cannot be empty',
            $messages['password']['isEmpty']
        );

        $inputFilter->setData([
            'currentPassword' => 'password',
            'password'        => str_repeat('a', 7),
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('password', $messages);
        $this->assertIsArray($messages['password']);
        $this->assertArrayHasKey('stringLengthTooShort', $messages['password']);
        $this->assertSame(
            '<b>Password</b> must have between 8 and 150 characters',
            $messages['password']['stringLengthTooShort']
        );

        $inputFilter->setData([
            'currentPassword' => 'password',
            'password'        => str_repeat('a', 151),
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('password', $messages);
        $this->assertIsArray($messages['password']);
        $this->assertArrayHasKey('stringLengthTooLong', $messages['password']);
        $this->assertSame(
            '<b>Password</b> must have between 8 and 150 characters',
            $messages['password']['stringLengthTooLong']
        );
    }

    public function testWillValidatePasswordConfirm(): void
    {
        $inputFilter = new ChangePasswordInputFilter();
        $inputFilter->init();

        $inputFilter->setData([
            'currentPassword' => 'password',
            'password'        => 'password',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('passwordConfirm', $messages);
        $this->assertIsArray($messages['passwordConfirm']);
        $this->assertArrayHasKey('isEmpty', $messages['passwordConfirm']);
        $this->assertSame(
            '<b>Confirm Password</b> is required and cannot be empty',
            $messages['passwordConfirm']['isEmpty']
        );

        $inputFilter->setData([
            'currentPassword' => 'password',
            'password'        => 'password',
            'passwordConfirm' => null,
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('passwordConfirm', $messages);
        $this->assertIsArray($messages['passwordConfirm']);
        $this->assertArrayHasKey('isEmpty', $messages['passwordConfirm']);
        $this->assertSame(
            '<b>Confirm Password</b> is required and cannot be empty',
            $messages['passwordConfirm']['isEmpty']
        );

        $inputFilter->setData([
            'currentPassword' => 'password',
            'password'        => 'password',
            'passwordConfirm' => '',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('passwordConfirm', $messages);
        $this->assertIsArray($messages['passwordConfirm']);
        $this->assertArrayHasKey('isEmpty', $messages['passwordConfirm']);
        $this->assertSame(
            '<b>Confirm Password</b> is required and cannot be empty',
            $messages['passwordConfirm']['isEmpty']
        );

        $inputFilter->setData([
            'currentPassword' => 'password',
            'password'        => 'password',
            'passwordConfirm' => '   ',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('passwordConfirm', $messages);
        $this->assertIsArray($messages['passwordConfirm']);
        $this->assertArrayHasKey('isEmpty', $messages['passwordConfirm']);
        $this->assertSame(
            '<b>Confirm Password</b> is required and cannot be empty',
            $messages['passwordConfirm']['isEmpty']
        );

        $inputFilter->setData([
            'currentPassword' => 'password',
            'password'        => 'password',
            'passwordConfirm' => str_repeat('a', 7),
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('passwordConfirm', $messages);
        $this->assertIsArray($messages['passwordConfirm']);
        $this->assertArrayHasKey('stringLengthTooShort', $messages['passwordConfirm']);
        $this->assertSame(
            '<b>Confirm Password</b> must have between 8 and 150 characters',
            $messages['passwordConfirm']['stringLengthTooShort']
        );

        $inputFilter->setData([
            'currentPassword' => 'password',
            'password'        => 'password',
            'passwordConfirm' => str_repeat('a', 151),
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('passwordConfirm', $messages);
        $this->assertIsArray($messages['passwordConfirm']);
        $this->assertArrayHasKey('stringLengthTooLong', $messages['passwordConfirm']);
        $this->assertSame(
            '<b>Confirm Password</b> must have between 8 and 150 characters',
            $messages['passwordConfirm']['stringLengthTooLong']
        );

        $inputFilter->setData([
            'currentPassword' => 'password',
            'password'        => 'password',
            'passwordConfirm' => 'passwords',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('passwordConfirm', $messages);
        $this->assertIsArray($messages['passwordConfirm']);
        $this->assertArrayHasKey('notSame', $messages['passwordConfirm']);
        $this->assertSame(
            '<b>Password</b> and <b>Confirm Password</b> do not match',
            $messages['passwordConfirm']['notSame']
        );
    }

    public function testWillAcceptValidData(): void
    {
        $inputFilter = new ChangePasswordInputFilter();
        $inputFilter->init();
        $inputFilter->setData([
            'currentPassword' => 'password',
            'password'        => 'password',
            'passwordConfirm' => 'password',
        ]);
        $this->assertTrue($inputFilter->isValid());
    }
}
