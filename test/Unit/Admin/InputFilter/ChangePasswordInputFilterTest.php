<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\InputFilter;

use Admin\Admin\InputFilter\ChangePasswordInputFilter;
use Admin\App\InputFilter\Input\PasswordInput;
use AdminTest\Unit\UnitTest;
use Core\App\Message;
use Laminas\Session\Container;
use Laminas\Session\Validator\Csrf;

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
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['currentPassword']['isEmpty']);

        $inputFilter->setData([
            'currentPassword' => null,
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('currentPassword', $messages);
        $this->assertIsArray($messages['currentPassword']);
        $this->assertArrayHasKey('isEmpty', $messages['currentPassword']);
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['currentPassword']['isEmpty']);

        $inputFilter->setData([
            'currentPassword' => '',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('currentPassword', $messages);
        $this->assertIsArray($messages['currentPassword']);
        $this->assertArrayHasKey('isEmpty', $messages['currentPassword']);
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['currentPassword']['isEmpty']);

        $inputFilter->setData([
            'currentPassword' => '   ',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('currentPassword', $messages);
        $this->assertIsArray($messages['currentPassword']);
        $this->assertArrayHasKey('isEmpty', $messages['currentPassword']);
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['currentPassword']['isEmpty']);
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
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['password']['isEmpty']);

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
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['password']['isEmpty']);

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
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['password']['isEmpty']);

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
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['password']['isEmpty']);

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
            Message::validatorLengthMinMax(PasswordInput::PASSWORD_MIN_LENGTH, PasswordInput::PASSWORD_MAX_LENGTH),
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
            Message::validatorLengthMinMax(PasswordInput::PASSWORD_MIN_LENGTH, PasswordInput::PASSWORD_MAX_LENGTH),
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
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['passwordConfirm']['isEmpty']);

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
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['passwordConfirm']['isEmpty']);

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
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['passwordConfirm']['isEmpty']);

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
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['passwordConfirm']['isEmpty']);

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
            Message::validatorLengthMinMax(PasswordInput::PASSWORD_MIN_LENGTH, PasswordInput::PASSWORD_MAX_LENGTH),
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
            Message::validatorLengthMinMax(PasswordInput::PASSWORD_MIN_LENGTH, PasswordInput::PASSWORD_MAX_LENGTH),
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
            Message::validatorMismatch('Password', 'Confirm password'),
            $messages['passwordConfirm']['notSame']
        );
    }

    public function testWillAcceptValidData(): void
    {
        $hash = (new Csrf(['session' => new Container()]))->getHash();

        $inputFilter = new ChangePasswordInputFilter();
        $inputFilter->init();
        $inputFilter->setData([
            'currentPassword'    => 'password',
            'password'           => 'password',
            'passwordConfirm'    => 'password',
            'changePasswordCsrf' => $hash,
        ]);
        $this->assertTrue($inputFilter->isValid());
    }
}
