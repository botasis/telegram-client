<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Client;

use Botasis\Client\Telegram\Client\Exception\TelegramRequestException;
use Botasis\Client\Telegram\Client\Exception\TooManyRequestsException;
use Botasis\Client\Telegram\Entity\InlineKeyboard\InlineKeyboardUpdate;
use Botasis\Client\Telegram\Entity\Message\Message;

interface TelegramClientInterface
{
    /**
     * @throws TelegramRequestException
     * @throws TooManyRequestsException
     */
    public function sendMessage(Message $message): ?array;

    /**
     * @throws TelegramRequestException
     * @throws TooManyRequestsException
     */
    public function updateKeyboard(InlineKeyboardUpdate $message): ?array;

    /**
     * @throws TelegramRequestException
     * @throws TooManyRequestsException
     */
    public function send(string $apiEndpoint, array $data = []): ?array;

    /**
     * @throws TelegramRequestException
     * @throws TooManyRequestsException
     */
    public function updateMessage(mixed $message): ?array;
}
