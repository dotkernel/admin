<?php

declare(strict_types=1);

namespace Admin\App\Plugin;

use Dot\Controller\Plugin\PluginInterface;
use Dot\DependencyInjection\Attribute\Inject;
use Dot\FlashMessenger\FlashMessengerInterface;
use Laminas\Form\Exception\ExceptionInterface;
use Laminas\Form\Form;
use Laminas\Form\FormElementManager;
use Laminas\Form\FormInterface;

use function array_merge;
use function is_array;
use function is_string;

class FormsPlugin implements PluginInterface
{
    #[Inject(
        FormElementManager::class,
        FlashMessengerInterface::class,
    )]
    public function __construct(
        protected FormElementManager $formElementManager,
        protected FlashMessengerInterface $flashMessenger,
    ) {
    }

    /**
     * @template TFilteredValues
     * @param Form<TFilteredValues> $form
     */
    public function restoreState(Form $form): void
    {
        $dataKey     = $form->getName() . '_data';
        $messagesKey = $form->getName() . '_messages';

        $data     = $this->flashMessenger->getData($dataKey) ?: [];
        $messages = $this->flashMessenger->getData($messagesKey) ?: [];

        $form->setData($data);
        $form->setMessages($messages);
    }

    /**
     * @template TFilteredValues
     * @param Form<TFilteredValues> $form
     * @throws ExceptionInterface
     */
    public function saveState(Form $form): void
    {
        $dataKey     = $form->getName() . '_data';
        $messagesKey = $form->getName() . '_messages';

        $this->flashMessenger->addData($dataKey, $form->getData(FormInterface::VALUES_AS_ARRAY));
        $this->flashMessenger->addData($messagesKey, $form->getMessages());
    }

    /**
     * @template TFilteredValues
     * @param Form<TFilteredValues> $form
     * @return non-empty-string[]
     * @throws ExceptionInterface
     */
    public function getMessages(Form $form): array
    {
        return $this->processFormMessages(
            $form->getMessages()
        );
    }

    /**
     * @template TFilteredValues
     * @param Form<TFilteredValues> $form
     * @throws ExceptionInterface
     */
    public function getMessagesAsString(Form $form): string
    {
        return $this->formMessagesToString($form->getMessages());
    }

    /**
     * @param array<int, non-empty-string[]|non-empty-array<int, non-empty-string>> $formMessages
     */
    private function formMessagesToString(array $formMessages): string
    {
        $messages = '';

        foreach ($formMessages as $message) {
            if (is_array($message)) {
                foreach ($message as $m) {
                    if (is_string($m)) {
                        $messages .= $m . '<br>';
                    } elseif (is_array($m)) {
                        $messages .= $this->formMessagesToString($m);
                    }
                }
            } elseif (is_string($message)) {
                $messages .= $message . '<br>';
            }
        }

        return $messages;
    }

    /**
     * @param array<int, non-empty-string[]|non-empty-array<int, non-empty-string>> $formMessages
     * @return non-empty-string[]
     */
    protected function processFormMessages(array $formMessages): array
    {
        $messages = [];

        /** @var non-empty-string $message */
        foreach ($formMessages as $message) {
            if (is_array($message)) {
                foreach ($message as $m) {
                    if (is_string($m)) {
                        $messages[] = $m;
                    } elseif (is_array($m)) {
                        $messages = array_merge($messages, $this->processFormMessages($m));
                    }
                }
            } elseif (is_string($message)) {
                $messages[] = $message;
            }
        }

        return $messages;
    }
}
