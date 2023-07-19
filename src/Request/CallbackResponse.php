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
        $data = [
            'callback_query_id' => $id,
            'show_alert' => $showAlert,
            'cache_time' => $cacheTime,
        ];

        if ($text !== null) {
            $data['text'] = $text;
        }

        if ($url !== null) {
            $data['url'] = $url;
        }

        parent::__construct(
            self::METHOD,
            $data,
            $successCallback,
            $errorCallback,
        );
    }
}
