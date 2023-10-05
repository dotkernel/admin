<?php

declare(strict_types=1);

namespace Frontend\App\Plugin;

use Dot\Controller\Plugin\PluginInterface;
use Dot\FlashMessenger\FlashMessengerInterface;
use Laminas\Form\Form;
use Laminas\Form\FormElementManager;
use Laminas\Form\FormInterface;

use function array_merge;
use function is_array;
use function is_string;

class FormsPlugin implements PluginInterface
{
    public function __construct(
        protected FormElementManager $formElementManager,
        protected ?FlashMessengerInterface $flashMessenger = null
    ) {
    }

    public function restoreState(Form $form): void
    {
        if ($this->flashMessenger instanceof FlashMessengerInterface) {
            $dataKey     = $form->getName() . '_data';
            $messagesKey = $form->getName() . '_messages';

            $data     = $this->flashMessenger->getData($dataKey) ?: [];
            $messages = $this->flashMessenger->getData($messagesKey) ?: [];

            $form->setData($data);
            $form->setMessages($messages);
        }
    }

    public function saveState(Form $form): void
    {
        if ($this->flashMessenger instanceof FlashMessengerInterface) {
            $dataKey     = $form->getName() . '_data';
            $messagesKey = $form->getName() . '_messages';

            $this->flashMessenger->addData($dataKey, $form->getData(FormInterface::VALUES_AS_ARRAY));
            $this->flashMessenger->addData($messagesKey, $form->getMessages());
        }
    }

    public function getMessages(Form $form): array
    {
        return $this->processFormMessages(
            $form->getMessages()
        );
    }

    public function getMessagesAsString(Form $form): string
    {
        return $this->formMessagesToString($form->getMessages());
    }

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
     * @param array $formMessages
     * @return array
     */
    protected function processFormMessages(array $formMessages): array
    {
        $messages = [];

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
