<?php

namespace Botasis\Client\Telegram\Client\Exception;

use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Symfony\Contracts\HttpClient\ResponseInterface as SymfonyResponseInterface;
use Throwable;

class TelegramRequestException extends RuntimeException
{
    public function __construct(
        string $message,
        public readonly ResponseInterface|SymfonyResponseInterface $response,
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
