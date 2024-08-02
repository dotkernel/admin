<?php

declare(strict_types=1);

namespace FrontendTest\Unit\Admin\InputFilter;

use Frontend\Admin\InputFilter\AccountInputFilter;
use FrontendTest\Unit\UnitTest;
use Laminas\Session\Container;
use Laminas\Session\Validator\Csrf;

use function str_repeat;

class AccountInputFilterTest extends UnitTest
{
    public function testWillValidateIdentity(): void
    {
        $inputFilter = new AccountInputFilter();
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

    public function testWillValidateFirstName(): void
    {
        $hash = (new Csrf(['session' => new Container()]))->getHash();

        $inputFilter = new AccountInputFilter();
        $inputFilter->init();

        $inputFilter->setData([
            'identity'    => 'test',
            'accountCsrf' => $hash,
        ]);
        $this->assertTrue($inputFilter->isValid());

        $inputFilter->setData([
            'identity'    => 'test',
            'firstName'   => null,
            'accountCsrf' => $hash,
        ]);
        $this->assertTrue($inputFilter->isValid());

        $inputFilter->setData([
            'identity'    => 'test',
            'firstName'   => '',
            'accountCsrf' => $hash,
        ]);
        $this->assertTrue($inputFilter->isValid());

        $inputFilter->setData([
            'identity'  => 'test',
            'firstName' => str_repeat('a', 151),
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
        $hash = (new Csrf(['session' => new Container()]))->getHash();

        $inputFilter = new AccountInputFilter();
        $inputFilter->init();

        $inputFilter->setData([
            'identity'    => 'test',
            'accountCsrf' => $hash,
        ]);
        $this->assertTrue($inputFilter->isValid());

        $inputFilter->setData([
            'identity'    => 'test',
            'lastName'    => null,
            'accountCsrf' => $hash,
        ]);
        $this->assertTrue($inputFilter->isValid());

        $inputFilter->setData([
            'identity'    => 'test',
            'lastName'    => '',
            'accountCsrf' => $hash,
        ]);
        $this->assertTrue($inputFilter->isValid());

        $inputFilter->setData([
            'identity'    => 'test',
            'lastName'    => str_repeat('a', 151),
            'accountCsrf' => $hash,
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

    public function testWillAcceptValidData(): void
    {
        $hash = (new Csrf(['session' => new Container()]))->getHash();

        $inputFilter = new AccountInputFilter();
        $inputFilter->init();
        $inputFilter->setData([
            'identity'    => 'identity',
            'firstName'   => 'firstName',
            'lastName'    => 'lastName',
            'accountCsrf' => $hash,
        ]);
        $this->assertTrue($inputFilter->isValid());
    }
}
