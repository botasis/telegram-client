<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Client;

use Botasis\Client\Telegram\Entity\InlineKeyboard\InlineKeyboardUpdate;
use Botasis\Client\Telegram\Entity\JoinRequestApproval;
use Botasis\Client\Telegram\Entity\Message\Message;
use Botasis\Client\Telegram\Entity\Message\MessageUpdate;
use Psr\Log\LoggerInterface;

final readonly class ClientLog implements ClientInterface
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function sendMessage(Message $message): ?array
    {
        $this->send('sendMessage', $message->getArray());

        return null;
    }

    public function updateKeyboard(InlineKeyboardUpdate $message): ?array
    {
        $this->send('sendMessage', $message->getArray());

        return null;
    }

    public function updateMessage(MessageUpdate $message): ?array
    {
        $this->send('editMessageText', $message->getArray());

        return null;
    }

    public function send(string $apiEndpoint, array $data = []): ?array
    {
        $fields = [
            'endpoint' => $apiEndpoint,
            'data' => $data,
        ];
        $this->logger->debug('A message to Telegram', $fields);

        return null;
    }

    public function approveChatJoinRequest(JoinRequestApproval $approval): ?array
    {
        return $this->send(
            'editMessageReplyMarkup',
            ['chat_id' => $approval->chatId, 'user_id' => $approval->userId]
        );
    }
}
