<?php

declare(strict_types=1);

namespace FrontendTest\Unit\App\Plugin;

use Dot\FlashMessenger\FlashMessengerInterface;
use Frontend\Admin\Form\LoginForm;
use Frontend\App\Plugin\FormsPlugin;
use FrontendTest\Unit\UnitTest;
use Laminas\Form\FormElementManager;
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

        $formsPlugin = new FormsPlugin($formElementManager);
        $this->assertInstanceOf(FormsPlugin::class, $formsPlugin);

        $formsPlugin = new FormsPlugin($formElementManager, $flashMessengerInterface);
        $this->assertInstanceOf(FormsPlugin::class, $formsPlugin);
    }

    /**
     * @throws Exception
     */
    public function testWillRestoreState(): void
    {
        $oldData     = [
            'username' => 'old-username',
            'password' => 'old-password',
        ];
        $oldMessages = [];

        $newData     = [
            'username' => 'new-username',
            'password' => 'new-password',
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
                function (string $key) use ($newData, $newMessages) {
                    return match ($key) {
                        'loginForm_data' => $newData,
                        'loginForm_messages' => $newMessages,
                        default => null,
                    };
                }
            );

        $form = new LoginForm('loginForm');
        $form->setData($oldData);
        $this->assertTrue($form->isValid());
        $this->assertSame($oldData, $form->getData());
        $this->assertIsArray($form->getMessages());
        $this->assertSame($oldMessages, $form->getMessages());
        (new FormsPlugin($formElementManager))->restoreState($form);
        $this->assertTrue($form->isValid());
        $this->assertSame($oldData, $form->getData());
        $this->assertIsArray($form->getMessages());
        $this->assertSame($oldMessages, $form->getMessages());

        $form = new LoginForm('loginForm');
        $form->setData($oldData);
        $this->assertTrue($form->isValid());
        $this->assertSame($oldData, $form->getData());
        $this->assertIsArray($form->getMessages());
        $this->assertSame($oldMessages, $form->getMessages());
        (new FormsPlugin($formElementManager, $flashMessengerInterface))->restoreState($form);
        $this->assertTrue($form->isValid());
        $this->assertSame($newData, $form->getData());
        $this->assertIsArray($form->getMessages());
        $this->assertSame($newMessages, $form->getMessages());
    }

    /**
     * @throws Exception
     */
    public function testWillSaveState(): void
    {
        $data     = [
            'username' => 'username',
            'password' => 'password',
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
