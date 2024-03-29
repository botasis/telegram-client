<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Request\InlineKeyboard;

final readonly class InlineKeyboardButton
{
    public function __construct(
        public string $label,
        public string $callbackData = '',
    ) {
    }
}
