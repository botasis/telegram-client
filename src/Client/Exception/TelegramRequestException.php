<?php

namespace Botasis\Client\Telegram\Client\Exception;

use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Throwable;

class TelegramRequestException extends RuntimeException
{
    public function __construct(
        string $message,
        public readonly ResponseInterface $response,
        public readonly array $responseDecoded,
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
