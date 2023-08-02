<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Client\Event;

use Botasis\Client\Telegram\Request\TelegramRequestInterface;
use Psr\EventDispatcher\StoppableEventInterface;
use Psr\Http\Message\ResponseInterface;

final class RequestErrorEvent implements StoppableEventInterface
{
    /**
     * @param bool $handledSuccessfully Set this to true if you don't want an exception to be thrown. Request will be treated as successfully finished and {@see RequestSuccessEvent} will be triggered.
     * @param bool $isPropagationStopped Set this to true to stop propagation of the event.
     */
    public function __construct(
        public readonly TelegramRequestInterface $request,
        public readonly ResponseInterface $response,
        public readonly array $responseDecoded,
        public bool $handledSuccessfully = false,
        public bool $isPropagationStopped = false,
    ) {
    }

    public function isPropagationStopped(): bool
    {
        return $this->isPropagationStopped;
    }
}
