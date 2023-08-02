<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Client\Event;

use Botasis\Client\Telegram\Request\TelegramRequestInterface;
use Psr\EventDispatcher\StoppableEventInterface;
use Psr\Http\Message\ResponseInterface;

final class RequestSuccessEvent implements StoppableEventInterface
{
    public function __construct(
        public readonly TelegramRequestInterface $request,
        public readonly ResponseInterface $response,
        public readonly array $responseDecoded,
        public bool $isPropagationStopped = false,
    )
    {
    }

    public function isPropagationStopped(): bool
    {
        return $this->isPropagationStopped;
    }
}
