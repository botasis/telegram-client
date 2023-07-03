<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Request;

final class CallbackResponse extends TelegramRequest
{
    public const METHOD = 'answerCallbackQuery';

    public function __construct(
        public string $id,
        public ?string $text = null,
        public bool $showAlert = false,
        public ?string $url = null,
        public int $cacheTime = 0,
        ?callable $successCallback = null,
        ?callable $errorCallback = null,
    ) {
        parent::__construct(
            self::METHOD,
            [
                'callback_query_id' => $id,
                'text' => $text,
                'show_alert' => $showAlert,
                'url' => $url,
                'cache_time' => $cacheTime,
            ],
            $successCallback,
            $errorCallback,
        );
    }
}
