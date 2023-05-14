<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Client;

use Botasis\Client\Telegram\Client\Exception\TelegramRequestException;
use Botasis\Client\Telegram\Client\Exception\TooManyRequestsException;
use Botasis\Client\Telegram\Entity\InlineKeyboard\InlineKeyboardUpdate;
use Botasis\Client\Telegram\Entity\JoinRequestApproval;
use Botasis\Client\Telegram\Entity\Message\Message;
use Botasis\Client\Telegram\Entity\Message\MessageUpdate;

interface ClientInterface
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
    public function updateMessage(MessageUpdate $message): ?array;

    /**
     * Use this method to approve a chat join request. The bot must be an administrator in the chat for this to work
     * and must have the can_invite_users administrator right.
     *
     * @throws TelegramRequestException
     * @throws TooManyRequestsException
     */
    public function approveChatJoinRequest(JoinRequestApproval $approval): ?array;
}
