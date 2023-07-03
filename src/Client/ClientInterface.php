<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Client;

use Botasis\Client\Telegram\Client\Exception\TelegramRequestException;
use Botasis\Client\Telegram\Client\Exception\TooManyRequestsException;
use Botasis\Client\Telegram\Request\TelegramRequestInterface;

interface ClientInterface
{
    public function withToken(string $token): self;

    /**
     * @throws TelegramRequestException
     * @throws TooManyRequestsException
     */
    public function send(TelegramRequestInterface $request): ?array;
}
