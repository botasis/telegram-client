<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Request;

use Psr\Http\Message\ResponseInterface;
use Throwable;

interface TelegramRequestInterface
{
    /**
     * Telegram API request method
     *
     * @see https://core.telegram.org/bots/api#available-methods     *
     * @return string
     */
    public function getMethod(): string;

    /**
     * Request data to be passed as a request body via POST
     *
     * @return array
     */
    public function getData(): array;

    /**
     * @return array<FileUpload>
     */
    public function getFiles(): array;

    /**
     * @deprecated Will be removed in 2.0
     *
     * Sets a callback which will be called when the request is successfully finished
     *  Callback must have a such signature: function(
     *      \Psr\Http\Message\ResponseInterface $response, // Telegram API response
     *      ?array $content, // Telegram API response decoded, as $response body may be null at this point
     *  ): void
     *
     * @param callable|null $callback
     * @psalm-param callable(ResponseInterface=, array=): void|null $callback
     *
     * @return self
     */
    public function onSuccess(?callable $callback): self;

    /**
     * @deprecated Will be removed in 2.0
     *
     * Returns success callback if it was set
     *
     * @psalm-pure
     * @return callable|null
     * @psalm-return callable(ResponseInterface=, array=): void|null
     */
    public function getSuccessCallback(): ?callable;

    /**
     * @deprecated Will be removed in 2.0
     *
     * Sets a callback which will be called when the request is finished with an error
     *  Callback must have a such signature: function(
     *      \Psr\Http\Message\ResponseInterface $response, // Telegram API response
     *      ?array $content, // Telegram API response decoded as $response body may be null at this point
     *      \Throwable $exception, // Exception prepared to be thrown due to an error
     *  ): array
     *
     * @param callable|null $callback
     * @psalm-param callable(ResponseInterface=, array=, Throwable=): array|null $callback
     *
     * @return self
     */
    public function onError(?callable $callback): self;

    /**
     * @deprecated Will be removed in 2.0
     *
     * Returns error callback if it was set
     *
     * @psalm-pure
     * @return callable|null
     * @psalm-return callable(ResponseInterface=, array=, Throwable=): array|null
     */
    public function getErrorCallback(): ?callable;
}
