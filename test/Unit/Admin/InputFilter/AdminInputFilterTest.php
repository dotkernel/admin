<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\InputFilter;

use Admin\Admin\InputFilter\CreateAdminInputFilter;
use Admin\App\InputFilter\Input\FirstNameInput;
use Admin\App\InputFilter\Input\IdentityInput;
use Admin\App\InputFilter\Input\LastNameInput;
use Admin\App\InputFilter\Input\PasswordInput;
use AdminTest\Unit\UnitTest;
use Core\Admin\Enum\AdminRoleEnum;
use Core\Admin\Enum\AdminStatusEnum;
use Core\App\Message;
use Laminas\Session\Container;
use Laminas\Session\Validator\Csrf;

use function str_repeat;

class AdminInputFilterTest extends UnitTest
{
    public function testWillValidateIdentity(): void
    {
        $inputFilter = new CreateAdminInputFilter();
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

        $inputFilter->setData([
            'identity' => 'id',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('identity', $messages);
        $this->assertIsArray($messages['identity']);
        $this->assertArrayHasKey('stringLengthTooShort', $messages['identity']);
        $this->assertSame(
            Message::validatorLengthMinMax(IdentityInput::IDENTITY_MIN_LENGTH, IdentityInput::IDENTITY_MAX_LENGTH),
            $messages['identity']['stringLengthTooShort']
        );

        $inputFilter->setData([
            'identity' => str_repeat('a', 101),
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('identity', $messages);
        $this->assertIsArray($messages['identity']);
        $this->assertArrayHasKey('stringLengthTooLong', $messages['identity']);
        $this->assertSame(
            Message::validatorLengthMinMax(IdentityInput::IDENTITY_MIN_LENGTH, IdentityInput::IDENTITY_MAX_LENGTH),
            $messages['identity']['stringLengthTooLong']
        );
    }

    public function testWillValidatePassword(): void
    {
        $inputFilter = new CreateAdminInputFilter();
        $inputFilter->init();

        $inputFilter->setData([
            'identity' => 'test',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('password', $messages);
        $this->assertIsArray($messages['password']);
        $this->assertArrayHasKey('isEmpty', $messages['password']);
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['password']['isEmpty']);

        $inputFilter->setData([
            'identity' => 'test',
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
            'identity' => 'test',
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
            'identity' => 'test',
            'password' => '   ',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('password', $messages);
        $this->assertIsArray($messages['password']);
        $this->assertArrayHasKey('isEmpty', $messages['password']);
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['password']['isEmpty']);

        $inputFilter->setData([
            'identity' => 'test',
            'password' => str_repeat('a', 7),
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
            'identity' => 'test',
            'password' => str_repeat('a', 151),
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
        $inputFilter = new CreateAdminInputFilter();
        $inputFilter->init();

        $inputFilter->setData([
            'identity' => 'test',
            'password' => 'password',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('passwordConfirm', $messages);
        $this->assertIsArray($messages['passwordConfirm']);
        $this->assertArrayHasKey('isEmpty', $messages['passwordConfirm']);
        $this->assertSame(Message::VALIDATOR_REQUIRED_FIELD, $messages['passwordConfirm']['isEmpty']);

        $inputFilter->setData([
            'identity'        => 'test',
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
            'identity'        => 'test',
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
            'identity'        => 'test',
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
            'identity'        => 'test',
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
            'identity'        => 'test',
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
            'identity'        => 'test',
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

    public function testWillValidateFirstName(): void
    {
        $hash = (new Csrf(['session' => new Container()]))->getHash();

        $inputFilter = new CreateAdminInputFilter();
        $inputFilter->init();

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'status'          => AdminStatusEnum::Active->value,
            'roles'           => [
                AdminRoleEnum::Admin->value,
            ],
            'adminCreateCsrf' => $hash,
        ]);
        $this->assertTrue($inputFilter->isValid());

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => null,
            'status'          => AdminStatusEnum::Active->value,
            'roles'           => [
                AdminRoleEnum::Admin->value,
            ],
            'adminCreateCsrf' => $hash,
        ]);
        $this->assertTrue($inputFilter->isValid());

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => '',
            'status'          => AdminStatusEnum::Active->value,
            'roles'           => [
                AdminRoleEnum::Admin->value,
            ],
            'adminCreateCsrf' => $hash,
        ]);
        $this->assertTrue($inputFilter->isValid());

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => str_repeat('a', 200),
            'status'          => AdminStatusEnum::Active->value,
            'roles'           => [
                AdminRoleEnum::Admin->value,
            ],
            'adminCreateCsrf' => $hash,
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('firstName', $messages);
        $this->assertIsArray($messages['firstName']);
        $this->assertArrayHasKey('stringLengthTooLong', $messages['firstName']);
        $this->assertSame(
            Message::validatorLengthMax(FirstNameInput::FIRSTNAME_MAX_LENGTH),
            $messages['firstName']['stringLengthTooLong']
        );
    }

    public function testWillValidateLastName(): void
    {
        $hash = (new Csrf(['session' => new Container()]))->getHash();

        $inputFilter = new CreateAdminInputFilter();
        $inputFilter->init();

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => 'firstName',
            'status'          => AdminStatusEnum::Active->value,
            'roles'           => [
                AdminRoleEnum::Admin->value,
            ],
            'adminCreateCsrf' => $hash,
        ]);
        $this->assertTrue($inputFilter->isValid());

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => 'firstName',
            'lastName'        => null,
            'status'          => AdminStatusEnum::Active->value,
            'roles'           => [
                AdminRoleEnum::Admin->value,
            ],
            'adminCreateCsrf' => $hash,
        ]);
        $this->assertTrue($inputFilter->isValid());

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => 'firstName',
            'lastName'        => '',
            'status'          => AdminStatusEnum::Active->value,
            'roles'           => [
                AdminRoleEnum::Admin->value,
            ],
            'adminCreateCsrf' => $hash,
        ]);
        $this->assertTrue($inputFilter->isValid());

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => 'firstName',
            'lastName'        => str_repeat('a', 200),
            'status'          => AdminStatusEnum::Active->value,
            'roles'           => [
                AdminRoleEnum::Admin->value,
            ],
            'adminCreateCsrf' => $hash,
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('lastName', $messages);
        $this->assertIsArray($messages['lastName']);
        $this->assertArrayHasKey('stringLengthTooLong', $messages['lastName']);
        $this->assertSame(
            Message::validatorLengthMax(LastNameInput::LASTNAME_MAX_LENGTH),
            $messages['lastName']['stringLengthTooLong']
        );
    }

    public function testWillValidateStatus(): void
    {
        $inputFilter = new CreateAdminInputFilter();
        $inputFilter->init();

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => 'firstName',
            'lastName'        => 'lastName',
            'roles'           => [
                AdminRoleEnum::Admin->value,
            ],
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('status', $messages);
        $this->assertIsArray($messages['status']);
        $this->assertArrayHasKey('isEmpty', $messages['status']);
        $this->assertSame(
            'Value is required and can\'t be empty',
            $messages['status']['isEmpty']
        );

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => 'firstName',
            'lastName'        => 'lastName',
            'status'          => 'status',
            'roles'           => [
                AdminRoleEnum::Admin->value,
            ],
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('status', $messages);
        $this->assertIsArray($messages['status']);
        $this->assertArrayHasKey('notInArray', $messages['status']);
        $this->assertSame(Message::invalidValue('status'), $messages['status']['notInArray']);
    }

    public function testWillValidateRoles(): void
    {
        $inputFilter = new CreateAdminInputFilter();
        $inputFilter->init();

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => 'firstName',
            'lastName'        => 'lastName',
            'status'          => AdminStatusEnum::Active->value,
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('roles', $messages);
        $this->assertIsArray($messages['roles']);
        $this->assertArrayHasKey('isEmpty', $messages['roles']);
        $this->assertSame(Message::RESTRICTION_ROLES, $messages['roles']['isEmpty']);

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => 'firstName',
            'lastName'        => 'lastName',
            'status'          => AdminStatusEnum::Active->value,
            'roles'           => [],
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('roles', $messages);
        $this->assertIsArray($messages['roles']);
        $this->assertArrayHasKey('isEmpty', $messages['roles']);
        $this->assertSame(Message::RESTRICTION_ROLES, $messages['roles']['isEmpty']);
    }

    public function testWillAcceptValidData(): void
    {
        $hash = (new Csrf(['session' => new Container()]))->getHash();

        $inputFilter = new CreateAdminInputFilter();
        $inputFilter->init();
        $inputFilter->setData([
            'identity'        => 'identity',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => 'firstName',
            'lastName'        => 'lastName',
            'status'          => AdminStatusEnum::Active->value,
            'roles'           => [
                AdminRoleEnum::Admin->value,
            ],
            'adminCreateCsrf' => $hash,
        ]);
        $this->assertTrue($inputFilter->isValid());
    }
}
