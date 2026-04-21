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
        $formElementManager      = $this->createStub(FormElementManager::class);
        $flashMessengerInterface = $this->createStub(FlashMessengerInterface::class);

        $formsPlugin = new FormsPlugin($formElementManager, $flashMessengerInterface);
        $this->assertSame(FormsPlugin::class, $formsPlugin::class);
    }

    /**
     * @throws Exception
     */
    public function testWillRestoreState(): void
    {
        $hash = (new Csrf(['session' => new Container()]))->getHash();

        /** @var non-empty-array<non-empty-string, non-empty-string> $oldData */
        $oldData = [
            'identity'  => 'old-username',
            'password'  => 'old-password',
            'loginCsrf' => $hash,
        ];
        $newData = [
            'identity'  => 'new-username',
            'password'  => 'new-password',
            'loginCsrf' => $hash,
        ];

        $formElementManager      = $this->createStub(FormElementManager::class);
        $flashMessengerInterface = $this->createMock(FlashMessengerInterface::class);
        $flashMessengerInterface
            ->expects($this->exactly(2))
            ->method('getData')
            ->willReturnCallback(
                fn (string $key) => match ($key) {
                    'loginForm_data' => $oldData,
                    'loginForm_messages' => [],
                    default => null,
                }
            );

        $formsPlugin = new FormsPlugin($formElementManager, $flashMessengerInterface);

        $form = new LoginForm('loginForm');
        $form->setData($oldData);
        $this->assertTrue($form->isValid());
        $formsPlugin->saveState($form);
        $this->assertIsArray($form->getData());
        $this->assertSame($oldData, $form->getData());
        $this->assertIsArray($form->getMessages());
        $this->assertCount(0, $form->getMessages());

        $form->setData($newData);
        $this->assertTrue($form->isValid());
        $this->assertIsArray($form->getData());
        $this->assertSame($newData, $form->getData());
        $this->assertIsArray($form->getMessages());
        $this->assertCount(0, $form->getMessages());

        $formsPlugin->restoreState($form);
        $this->assertTrue($form->isValid());
        $formData = $form->getData();
        $this->assertIsArray($formData);
        $this->assertArrayHasKey('identity', $formData);
        $this->assertSame($oldData['identity'], $formData['identity']);
        $this->assertArrayHasKey('password', $formData);
        $this->assertSame($oldData['password'], $formData['password']);
        $this->assertArrayHasKey('loginCsrf', $formData);
        $this->assertSame($oldData['loginCsrf'], $formData['loginCsrf']);
        $this->assertIsArray($form->getMessages());
        $this->assertCount(0, $form->getMessages());
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

        $formElementManager      = $this->createStub(FormElementManager::class);
        $flashMessengerInterface = $this->getDummyFlashMessenger();

        $form = new LoginForm('loginForm');
        $form->setData($data);
        $this->assertTrue($form->isValid());

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

        $formElementManager      = $this->createStub(FormElementManager::class);
        $flashMessengerInterface = $this->createStub(FlashMessengerInterface::class);

        $formsPlugin = new FormsPlugin($formElementManager, $flashMessengerInterface);

        $messages = $formsPlugin->getMessages($form);
        $this->assertIsArray($messages);
        $this->assertNotEmpty($messages);

        $messagesAsString = $formsPlugin->getMessagesAsString($form);
        $this->assertIsString($messagesAsString);
        $this->assertNotEmpty($messagesAsString);
    }

    private function getDummyFlashMessenger(): FlashMessengerInterface
    {
        return new class implements FlashMessengerInterface {
            /** @var array<non-empty-string, mixed> $data */
            private array $data = [];
            /** @var array<non-empty-string, mixed> $messages */
            private array $messages = [];

            /**
             * @param non-empty-string $channel
             */
            public function addData(
                string $key,
                mixed $value,
                string $channel = FlashMessengerInterface::DEFAULT_CHANNEL,
            ): void {
                if (! isset($this->data[$channel])) {
                    $this->data[$channel] = [];
                }

                $this->data[$channel][$key] = $value;
            }

            public function getData(string $key, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): mixed
            {
                return $this->data[$channel][$key] ?? null;
            }

            /**
             * @param string|string[] $message
             * @param non-empty-string $channel
             */
            public function addMessage(
                string $type,
                array|string $message,
                string $channel = FlashMessengerInterface::DEFAULT_CHANNEL,
            ): void {
                $message = (array) $message;
                foreach ($message as $msg) {
                    $this->messages[$channel][$type][] = $msg;
                }
            }

            /**
             * @return array<string, array<int, string>>
             */
            public function getMessages(
                ?string $type = null,
                string $channel = FlashMessengerInterface::DEFAULT_CHANNEL,
            ): array {
                return $this->messages[$channel][$type] ?? [];
            }

            /**
             * @param string|string[] $error
             * @param non-empty-string $channel
             */
            public function addError(
                array|string $error,
                string $channel = FlashMessengerInterface::DEFAULT_CHANNEL,
            ): void {
                $this->addMessage(FlashMessengerInterface::ERROR, $error, $channel);
            }

            /**
             * @param string|string[] $info
             * @param non-empty-string $channel
             */
            public function addInfo(
                array|string $info,
                string $channel = FlashMessengerInterface::DEFAULT_CHANNEL,
            ): void {
                $this->addMessage(FlashMessengerInterface::INFO, $info, $channel);
            }

            /**
             * @param string|string[] $warning
             * @param non-empty-string $channel
             */
            public function addWarning(
                array|string $warning,
                string $channel = FlashMessengerInterface::DEFAULT_CHANNEL,
            ): void {
                $this->addMessage(FlashMessengerInterface::WARNING, $warning, $channel);
            }

            /**
             * @param string|string[] $success
             * @param non-empty-string $channel
             */
            public function addSuccess(
                array|string $success,
                string $channel = FlashMessengerInterface::DEFAULT_CHANNEL,
            ): void {
                $this->addMessage(FlashMessengerInterface::SUCCESS, $success, $channel);
            }
        };
    }
}
