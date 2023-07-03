<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Request\InlineKeyboard;

use Botasis\Client\Telegram\Request\TelegramRequest;

final class InlineKeyboardUpdate extends TelegramRequest
{
    /**
     * @param InlineKeyboardButton[][] $inlineKeyboard
     */
    public function __construct(
        private readonly string $chatId,
        private readonly string $messageId,
        private readonly array $inlineKeyboard = [],
        ?callable $successCallback = null,
        ?callable $errorCallback = null,
    ) {
        parent::__construct('editMessageReplyMarkup', $this->createData(), $successCallback, $errorCallback);
    }

    private function createData(): array
    {
        $result = [
            'chat_id' => $this->chatId,
            'message_id' => $this->messageId,
            'reply_markup' => [],
        ];

        foreach ($this->inlineKeyboard as $i => $row) {
            foreach ($row as $button) {
                $result['reply_markup']['inline_keyboard'][$i][] = [
                    'text' => $button->label,
                    'callback_data' => $button->callbackData,
                ];
            }
        }

        return $result;
    }
}
