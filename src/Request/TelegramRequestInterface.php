<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Request;

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
}
