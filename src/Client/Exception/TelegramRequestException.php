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
        public readonly array $responseDecoded,
        int $code = 0,
        Throwable $previous = null
    ) {
        if ($response instanceof SymfonyResponseInterface && !$response instanceof ResponseInterface) {
            trigger_deprecation(
                'botasis/telegram-client',
                '1.1',
                'Support for Symfony ResponseInterface will be removed in version 2.0. Use PSR response instead.'
            );

        }

        parent::__construct($message, $code, $previous);
    }
}
