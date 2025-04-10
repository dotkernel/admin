<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\InputFilter;

use Admin\Admin\InputFilter\EditAccountInputFilter;
use Admin\App\InputFilter\Input\FirstNameInput;
use Admin\App\InputFilter\Input\IdentityInput;
use Admin\App\InputFilter\Input\LastNameInput;
use AdminTest\Unit\UnitTest;
use Core\App\Message;
use Laminas\Session\Container;
use Laminas\Session\Validator\Csrf;

use function str_repeat;

class AccountInputFilterTest extends UnitTest
{
    public function testWillValidateIdentity(): void
    {
        $inputFilter = new EditAccountInputFilter();
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

        $inputFilter->setData([
            'identity' => '\'\'\'',
        ]);
        $this->assertFalse($inputFilter->isValid());
        $messages = $inputFilter->getMessages();
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('identity', $messages);
        $this->assertIsArray($messages['identity']);
        $this->assertArrayHasKey('regexNotMatch', $messages['identity']);
        $this->assertSame(Message::VALIDATOR_INVALID_CHARACTERS, $messages['identity']['regexNotMatch']);
    }

    public function testWillValidateFirstName(): void
    {
        $hash = (new Csrf(['session' => new Container()]))->getHash();

        $inputFilter = new EditAccountInputFilter();
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
            'firstName' => str_repeat('a', 200),
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

        $inputFilter = new EditAccountInputFilter();
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
            'lastName'    => str_repeat('a', 200),
            'accountCsrf' => $hash,
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

    public function testWillAcceptValidData(): void
    {
        $hash = (new Csrf(['session' => new Container()]))->getHash();

        $inputFilter = new EditAccountInputFilter();
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
