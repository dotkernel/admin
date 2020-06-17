<?php

/**
 * @see https://github.com/dotkernel/dot-controller-plugin-forms/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-controller-plugin-forms/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace Frontend\Plugin;

use Frontend\Plugin\Exception\RuntimeException;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Form\Factory\FormAbstractServiceFactory;
use Dot\Form\FormElementManager;
use Psr\Container\ContainerInterface;
use Laminas\Form\Form;
use Laminas\Form\FormInterface;

/**
 * Class FormsPlugin
 * @package Dot\Controller\Plugin\Forms
 */
class FormsPlugin implements PluginInterface
{
    /** @var  FormElementManager */
    protected $formElementManager;

    /** @var  ContainerInterface */
    protected $container;

    /** @var  FlashMessengerInterface */
    protected $flashMessenger;

    /**
     * FormsPlugin constructor.
     * @param FormElementManager $formManager
     * @param ContainerInterface $container
     * @param FlashMessengerInterface|null $flashMessenger
     */
    public function __construct(
        FormElementManager $formManager,
        ContainerInterface $container,
        FlashMessengerInterface $flashMessenger = null
    ) {
        $this->formElementManager = $formManager;
        $this->container = $container;
        $this->flashMessenger = $flashMessenger;
    }

    /**
     * @param string $name
     * @return object
     */
    public function __invoke(string $name = null)
    {
        if (is_null($name)) {
            return $this;
        }

        $result = null;
        // check the container first, in case there is a form to get through the abstract factory
        $abstractFormName = FormAbstractServiceFactory::PREFIX . '.' . $name;
        if ($this->container->has($abstractFormName)) {
            $result = $this->container->get($abstractFormName);
        } elseif ($this->formElementManager->has($name)) {
            $result = $this->formElementManager->get($name);
        }

        if (!$result) {
            throw new RuntimeException(
                "Form, fieldset or element with name $result could not be created. ' .
                'Are you sure you registered it in the form manager?"
            );
        }

        if ($result instanceof Form) {
            $this->restoreState($result);
        }

        return $result;
    }

    /**
     * @param Form $form
     */
    public function restoreState(Form $form)
    {
        if ($this->flashMessenger) {
            $dataKey = $form->getName() . '_data';
            $messagesKey = $form->getName() . '_messages';

            $data = $this->flashMessenger->getData($dataKey) ?: [];
            $messages = $this->flashMessenger->getData($messagesKey) ?: [];

            $form->setData($data);
            $form->setMessages($messages);
        }
    }

    /**
     * @param Form $form
     */
    public function saveState(Form $form)
    {
        if ($this->flashMessenger) {
            $dataKey = $form->getName() . '_data';
            $messagesKey = $form->getName() . '_messages';

            $this->flashMessenger->addData($dataKey, $form->getData(FormInterface::VALUES_AS_ARRAY));
            $this->flashMessenger->addData($messagesKey, $form->getMessages());
        }
    }

    /**
     * @param Form $form
     * @return array
     */
    public function getMessages(Form $form): array
    {
        $formMessages = $form->getMessages();
        return $this->processFormMessages($formMessages);
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

    /**
     * @param Form $form
     * @return array
     */
    public function getErrors(Form $form): array
    {
        $formMessages = $form->getMessages();
        return $this->processFormErrors($formMessages);
    }

    /**
     * @param array $formMessages
     * @return array
     */
    protected function processFormErrors(array $formMessages): array
    {
        $errors = [];
        foreach ($formMessages as $key => $message) {
            if (is_array($message)) {
                if (!isset($errors[$key])) {
                    $errors[$key] = array();
                }

                foreach ($message as $k => $m) {
                    if (is_string($m)) {
                        $errors[$key][] = $m;
                    } elseif (is_array($m)) {
                        $errors[$key][$k] = $this->processFormErrors($m);
                    }
                }
            } elseif (is_string($message)) {
                $errors[] = $message;
            }
        }

        return $errors;
    }
}
