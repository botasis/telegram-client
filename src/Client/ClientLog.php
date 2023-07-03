<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Client;

use Botasis\Client\Telegram\Request\InlineKeyboard\InlineKeyboardUpdate;
use Botasis\Client\Telegram\Request\JoinRequestApproval;
use Botasis\Client\Telegram\Request\Message\Message;
use Botasis\Client\Telegram\Request\Message\MessageUpdate;
use Botasis\Client\Telegram\Request\TelegramRequestInterface;
use Psr\Log\LoggerInterface;

final readonly class ClientLog implements ClientInterface
{
    public function __construct(private string $token, private LoggerInterface $logger)
    {
    }

    public function withToken(string $token): ClientInterface
    {
        return new self($token, $this->logger);
    }

    public function send(TelegramRequestInterface $request): ?array
    {
        $fields = [
            'token' => $this->token,
            'endpoint' => $request->getMethod(),
            'data' => $request->getData(),
        ];
        $this->logger->debug('A request to the Telegram API', $fields);

        return null;
    }
}
