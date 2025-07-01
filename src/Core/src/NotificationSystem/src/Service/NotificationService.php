<?php

declare(strict_types=1);

namespace Core\NotificationSystem\Service;

use Core\User\Entity\User;
use Dot\DependencyInjection\Attribute\Inject;
use Laminas\Json\Encoder;
use Socket\Raw\Factory;
use Socket\Raw\Socket;

class NotificationService
{
    /**
     * @param array<non-empty-string, mixed> $config
     */
    #[Inject(
        'config.notification.server',
    )]
    public function __construct(
        private readonly array $config
    ) {
    }

    public function createClient(): Socket
    {
        $socketRawFactory = new Factory();
        return $socketRawFactory->createClient(
            $this->config['protocol'] . '://' . $this->config['host'] . ':' . $this->config['port']
        );
    }

    public function send(string $message): void
    {
        $this->createClient()->write($message . $this->config['eof']);
    }

    /**
     * @param array<non-empty-string, mixed> $data
     */
    protected function encodeEmailMessage(array $data): string
    {
        return Encoder::encode($data);
    }

    public function sendNewAccountNotification(User $user): void
    {
        $data['userUuid'] = $user->getUuid()->toString();
        $this->send($this->encodeEmailMessage($data));
    }
}
