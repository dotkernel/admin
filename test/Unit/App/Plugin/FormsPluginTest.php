<?php

declare(strict_types=1);

namespace AdminTest\Unit\App\Plugin;

use Admin\Admin\Form\LoginForm;
use Admin\App\Plugin\FormsPlugin;
use AdminTest\Unit\UnitTest;
use Dot\FlashMessenger\FlashMessengerInterface;
use Laminas\Form\FormElementManager;
use Laminas\Session\Container;
use Laminas\Session\Validator\Csrf;
use PHPUnit\Framework\MockObject\Exception;

class FormsPluginTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testWillInstantiate(): void
    {
        $formElementManager      = $this->createMock(FormElementManager::class);
        $flashMessengerInterface = $this->createMock(FlashMessengerInterface::class);

        $formsPlugin = new FormsPlugin($formElementManager, $flashMessengerInterface);
        $this->assertSame(FormsPlugin::class, $formsPlugin::class);
    }

    /**
     * @throws Exception
     */
    public function testWillRestoreState(): void
    {
        $hash = (new Csrf(['session' => new Container()]))->getHash();

        /** @var array<string, string> $oldData */
        $oldData     = [
            'identity'  => 'old-username',
            'password'  => 'old-password',
            'loginCsrf' => $hash,
        ];
        $oldMessages = [];

        $newData     = [
            'identity'  => 'new-username',
            'password'  => 'new-password',
            'loginCsrf' => $hash,
        ];
        $newMessages = [
            'test-message',
        ];

        $formElementManager      = $this->createMock(FormElementManager::class);
        $flashMessengerInterface = $this->createMock(FlashMessengerInterface::class);
        $flashMessengerInterface
            ->expects($this->exactly(2))
            ->method('getData')
            ->willReturnCallback(
                fn (string $key) => match ($key) {
                    'loginForm_data' => $oldData,
                    'loginForm_messages' => $oldMessages,
                    default => null,
                }
            );

        $formsPlugin = new FormsPlugin($formElementManager, $flashMessengerInterface);

        $form = new LoginForm('loginForm');
        $form->setData($oldData);
        $this->assertTrue($form->isValid());
        $formsPlugin->saveState($form);
        $this->assertSame($oldData, $form->getData());
        $this->assertIsArray($form->getMessages());
        $this->assertSame($oldMessages, $form->getMessages());

        $form->setData($newData);
        $this->assertTrue($form->isValid());
        $this->assertSame($newData, $form->getData());
        $this->assertIsArray($form->getMessages());
        $this->assertSame($oldMessages, $form->getMessages());

        $formsPlugin->restoreState($form);
        $this->assertTrue($form->isValid());
        $this->assertSame($oldData, $form->getData());
        $this->assertIsArray($form->getMessages());
        $this->assertSame($oldMessages, $form->getMessages());
    }

    /**
     * @throws Exception
     */
    public function testWillSaveState(): void
    {
        $hash = (new Csrf(['session' => new Container()]))->getHash();

        $data     = [
            'identity'  => 'username',
            'password'  => 'password',
            'loginCsrf' => $hash,
        ];
        $messages = [
            'test-message',
        ];

        $formElementManager      = $this->createMock(FormElementManager::class);
        $flashMessengerInterface = $this->getDummyFlashMessenger();

        $form = new LoginForm('loginForm');
        $form->setData($data);
        $this->assertTrue($form->isValid());

        $this->assertIsArray($flashMessengerInterface->getAllData());
        $this->assertEmpty($flashMessengerInterface->getAllData());
        $this->assertIsArray($flashMessengerInterface->getMessages());
        $this->assertEmpty($flashMessengerInterface->getMessages());

        $flashMessengerInterface->addData('loginForm_data', $data);
        $flashMessengerInterface->addMessage('loginForm_messages', $messages);
        (new FormsPlugin($formElementManager, $flashMessengerInterface))->saveState($form);
        $this->assertIsArray($flashMessengerInterface->getData('loginForm_data'));
        $this->assertSame($data, $flashMessengerInterface->getData('loginForm_data'));
        $this->assertIsArray($flashMessengerInterface->getMessages('loginForm_messages'));
        $this->assertSame($messages, $flashMessengerInterface->getMessages('loginForm_messages'));
    }

    /**
     * @throws Exception
     */
    public function testWillGetMessages(): void
    {
        $form = new LoginForm('loginForm');
        $form->setData([]);
        $this->assertFalse($form->isValid());

        $formElementManager      = $this->createMock(FormElementManager::class);
        $flashMessengerInterface = $this->createMock(FlashMessengerInterface::class);

        $formsPlugin = new FormsPlugin($formElementManager, $flashMessengerInterface);

        $messages = $formsPlugin->getMessages($form);
        $this->assertIsArray($messages);
        $this->assertNotEmpty($messages);

        $messagesAsString = $formsPlugin->getMessagesAsString($form);
        $this->assertIsString($messagesAsString);
        $this->assertNotEmpty($messagesAsString);
    }

    private function getDummyFlashMessenger(): object
    {
        return new class implements FlashMessengerInterface {
            private array $data     = [];
            private array $messages = [];

            public function addData(
                string $key,
                mixed $value,
                string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
            ): void {
                if (! isset($this->data[$channel])) {
                    $this->data[$channel] = [];
                }

                $this->data[$channel][$key] = $value;
            }

            public function getAllData(string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): mixed
            {
                return $this->data[$channel] ?? [];
            }

            public function getData(string $key, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): mixed
            {
                return $this->data[$channel][$key] ?? null;
            }

            public function addMessage(
                string $type,
                array|string $message,
                string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
            ): void {
                $message = (array) $message;
                foreach ($message as $msg) {
                    $this->messages[$channel][$type][] = $msg;
                }
            }

            public function getMessages(
                ?string $type = null,
                string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
            ): array {
                return $this->messages[$channel][$type] ?? [];
            }

            public function addError(
                array|string $error,
                string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
            ): void {
                $this->addMessage(FlashMessengerInterface::ERROR, $error, $channel);
            }

            public function addInfo(
                array|string $info,
                string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
            ): void {
                $this->addMessage(FlashMessengerInterface::INFO, $info, $channel);
            }

            public function addWarning(
                array|string $warning,
                string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
            ): void {
                $this->addMessage(FlashMessengerInterface::WARNING, $warning, $channel);
            }

            public function addSuccess(
                array|string $success,
                string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
            ): void {
                $this->addMessage(FlashMessengerInterface::SUCCESS, $success, $channel);
            }
        };
    }
}
