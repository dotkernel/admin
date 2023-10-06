<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\InputFilter;

use Frontend\Admin\Entity\Admin;
use Frontend\Admin\Entity\AdminRole;
use Frontend\Admin\InputFilter\AdminInputFilter;
use FrontendTest\Unit\UnitTest;

use function str_repeat;

class AdminInputFilterTest extends UnitTest
{
    public function testWillValidateIdentity(): void
    {
        $inputFilter = new AdminInputFilter();
        $inputFilter->init();

        $inputFilter->setData([]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('identity', $messages);
        $this->assertIsArray($messages['identity']);
        $this->assertArrayHasKey('isEmpty', $messages['identity']);
        $this->assertSame('<b>Identity</b> is required and cannot be empty', $messages['identity']['isEmpty']);

        $inputFilter->setData([
            'identity' => null,
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('identity', $messages);
        $this->assertIsArray($messages['identity']);
        $this->assertArrayHasKey('isEmpty', $messages['identity']);
        $this->assertSame('<b>Identity</b> is required and cannot be empty', $messages['identity']['isEmpty']);

        $inputFilter->setData([
            'identity' => '',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('identity', $messages);
        $this->assertIsArray($messages['identity']);
        $this->assertArrayHasKey('isEmpty', $messages['identity']);
        $this->assertSame('<b>Identity</b> is required and cannot be empty', $messages['identity']['isEmpty']);

        $inputFilter->setData([
            'identity' => '   ',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('identity', $messages);
        $this->assertIsArray($messages['identity']);
        $this->assertArrayHasKey('isEmpty', $messages['identity']);
        $this->assertSame('<b>Identity</b> is required and cannot be empty', $messages['identity']['isEmpty']);

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
            '<b>Identity</b> must have between 3 and 100 characters',
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
            '<b>Identity</b> must have between 3 and 100 characters',
            $messages['identity']['stringLengthTooLong']
        );

        $inputFilter->setData([
            'identity' => '\'\'\'',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('identity', $messages);
        $this->assertIsArray($messages['identity']);
        $this->assertArrayHasKey('regexNotMatch', $messages['identity']);
        $this->assertSame(
            '<b>Identity</b> contains invalid characters',
            $messages['identity']['regexNotMatch']
        );
    }

    public function testWillValidatePassword(): void
    {
        $inputFilter = new AdminInputFilter();
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
        $this->assertSame('<b>Password</b> is required and cannot be empty', $messages['password']['isEmpty']);

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
        $this->assertSame('<b>Password</b> is required and cannot be empty', $messages['password']['isEmpty']);

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
        $this->assertSame('<b>Password</b> is required and cannot be empty', $messages['password']['isEmpty']);

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
        $this->assertSame('<b>Password</b> is required and cannot be empty', $messages['password']['isEmpty']);

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
            '<b>Password</b> must have between 8 and 150 characters',
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
            '<b>Password</b> must have between 8 and 150 characters',
            $messages['password']['stringLengthTooLong']
        );
    }

    public function testWillValidatePasswordConfirm(): void
    {
        $inputFilter = new AdminInputFilter();
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
        $this->assertSame(
            '<b>Confirm Password</b> is required and cannot be empty',
            $messages['passwordConfirm']['isEmpty']
        );

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
        $this->assertSame(
            '<b>Confirm Password</b> is required and cannot be empty',
            $messages['passwordConfirm']['isEmpty']
        );

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
        $this->assertSame(
            '<b>Confirm Password</b> is required and cannot be empty',
            $messages['passwordConfirm']['isEmpty']
        );

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
        $this->assertSame(
            '<b>Confirm Password</b> is required and cannot be empty',
            $messages['passwordConfirm']['isEmpty']
        );

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
            '<b>Confirm Password</b> must have between 8 and 150 characters',
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
            '<b>Confirm Password</b> must have between 8 and 150 characters',
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
            '<b>Password</b> and <b>Confirm Password</b> do not match',
            $messages['passwordConfirm']['notSame']
        );
    }

    public function testWillValidateFirstName(): void
    {
        $inputFilter = new AdminInputFilter();
        $inputFilter->init();

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'status'          => Admin::STATUS_ACTIVE,
            'roles'           => [
                AdminRole::ROLE_ADMIN,
            ],
        ]);
        $this->assertTrue($inputFilter->isValid());

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => null,
            'status'          => Admin::STATUS_ACTIVE,
            'roles'           => [
                AdminRole::ROLE_ADMIN,
            ],
        ]);
        $this->assertTrue($inputFilter->isValid());

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => '',
            'status'          => Admin::STATUS_ACTIVE,
            'roles'           => [
                AdminRole::ROLE_ADMIN,
            ],
        ]);
        $this->assertTrue($inputFilter->isValid());

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => str_repeat('a', 151),
            'status'          => Admin::STATUS_ACTIVE,
            'roles'           => [
                AdminRole::ROLE_ADMIN,
            ],
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('firstName', $messages);
        $this->assertIsArray($messages['firstName']);
        $this->assertArrayHasKey('stringLengthTooLong', $messages['firstName']);
        $this->assertSame(
            '<b>First name</b> must be max 150 characters long.',
            $messages['firstName']['stringLengthTooLong']
        );
    }

    public function testWillValidateLastName(): void
    {
        $inputFilter = new AdminInputFilter();
        $inputFilter->init();

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => 'firstName',
            'status'          => Admin::STATUS_ACTIVE,
            'roles'           => [
                AdminRole::ROLE_ADMIN,
            ],
        ]);
        $this->assertTrue($inputFilter->isValid());

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => 'firstName',
            'lastName'        => null,
            'status'          => Admin::STATUS_ACTIVE,
            'roles'           => [
                AdminRole::ROLE_ADMIN,
            ],
        ]);
        $this->assertTrue($inputFilter->isValid());

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => 'firstName',
            'lastName'        => '',
            'status'          => Admin::STATUS_ACTIVE,
            'roles'           => [
                AdminRole::ROLE_ADMIN,
            ],
        ]);
        $this->assertTrue($inputFilter->isValid());

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => 'firstName',
            'lastName'        => str_repeat('a', 151),
            'status'          => Admin::STATUS_ACTIVE,
            'roles'           => [
                AdminRole::ROLE_ADMIN,
            ],
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('lastName', $messages);
        $this->assertIsArray($messages['lastName']);
        $this->assertArrayHasKey('stringLengthTooLong', $messages['lastName']);
        $this->assertSame(
            '<b>Last name</b> must be max 150 characters long.',
            $messages['lastName']['stringLengthTooLong']
        );
    }

    public function testWillValidateStatus(): void
    {
        $inputFilter = new AdminInputFilter();
        $inputFilter->init();

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => 'firstName',
            'lastName'        => 'lastName',
            'roles'           => [
                AdminRole::ROLE_ADMIN,
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
                AdminRole::ROLE_ADMIN,
            ],
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('status', $messages);
        $this->assertIsArray($messages['status']);
        $this->assertArrayHasKey('notInArray', $messages['status']);
        $this->assertSame(
            'The input was not found in the haystack',
            $messages['status']['notInArray']
        );
    }

    public function testWillValidateRoles(): void
    {
        $inputFilter = new AdminInputFilter();
        $inputFilter->init();

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => 'firstName',
            'lastName'        => 'lastName',
            'status'          => Admin::STATUS_ACTIVE,
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('roles', $messages);
        $this->assertIsArray($messages['roles']);
        $this->assertArrayHasKey('isEmpty', $messages['roles']);
        $this->assertSame(
            'Please select at least one role',
            $messages['roles']['isEmpty']
        );

        $inputFilter->setData([
            'identity'        => 'test',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => 'firstName',
            'lastName'        => 'lastName',
            'status'          => Admin::STATUS_ACTIVE,
            'roles'           => [],
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('roles', $messages);
        $this->assertIsArray($messages['roles']);
        $this->assertArrayHasKey('isEmpty', $messages['roles']);
        $this->assertSame(
            'Please select at least one role',
            $messages['roles']['isEmpty']
        );
    }

    public function testWillAcceptValidData(): void
    {
        $inputFilter = new AdminInputFilter();
        $inputFilter->init();
        $inputFilter->setData([
            'identity'        => 'identity',
            'password'        => 'password',
            'passwordConfirm' => 'password',
            'firstName'       => 'firstName',
            'lastName'        => 'lastName',
            'status'          => Admin::STATUS_ACTIVE,
            'roles'           => [
                AdminRole::ROLE_ADMIN,
            ],
        ]);
        $this->assertTrue($inputFilter->isValid());
    }
}
