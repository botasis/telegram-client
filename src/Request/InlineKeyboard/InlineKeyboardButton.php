<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Request\InlineKeyboard;

final readonly class InlineKeyboardButton
{
    public function __construct(
        public string $label,
        public string $callbackData = '',
        public ?string $url = null,
        public ?array $webApp = null,
        public ?array $loginUrl = null,
        public ?string $switchInlineQuery = null,
        public ?string $switchInlineQueryCurrentChat = null,
        public ?array $switchInlineQueryChosenChat = null,
        public ?array $copyText = null,
        public ?array $callbackGame = null,
        public ?bool $pay = null,
    ) {
    }

    public function getData(): array
    {
        $result = ['text' => $this->label];

        if ($this->callbackData !== '') {
            $result['callback_data'] = $this->callbackData;
        }

        if ($this->url !== null && $this->url !== '') {
            $result['url'] = $this->url;
        }

        if ($this->webApp !== null) {
            $result['web_app'] = $this->webApp;
        }

        if ($this->loginUrl !== null) {
            $result['login_url'] = $this->loginUrl;
        }

        if ($this->switchInlineQuery !== null) {
            $result['switch_inline_query'] = $this->switchInlineQuery;
        }

        if ($this->switchInlineQueryCurrentChat !== null) {
            $result['switch_inline_query_current_chat'] = $this->switchInlineQueryCurrentChat;
        }

        if ($this->switchInlineQueryChosenChat !== null) {
            $result['switch_inline_query_chosen_chat'] = $this->switchInlineQueryChosenChat;
        }

        if ($this->copyText !== null) {
            $result['copy_text'] = $this->copyText;
        }

        if ($this->callbackGame !== null) {
            $result['callback_game'] = $this->callbackGame;
        }

        if ($this->pay !== null) {
            $result['pay'] = $this->pay;
        }

        return $result;
    }
}
