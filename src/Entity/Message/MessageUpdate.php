<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Entity\Message;

use Botasis\Client\Telegram\Entity\InlineKeyboard\InlineKeyboardButton;

final readonly class MessageUpdate
{
    /**
     * @param InlineKeyboardButton[][] $inlineKeyboard
     */
    public function __construct(
        public string $text,
        public MessageFormat $format,
        public string $chatId,
        public string $messageId,
        public array $inlineKeyboard = [],
    ) {
    }

    public function getArray(): array
    {
        $result = [
            'text' => $this->text,
            'chat_id' => $this->chatId,
            'message_id' => $this->messageId,
        ];

        if ($this->format === MessageFormat::MARKDOWN) {
            $result['parse_mode'] = 'MarkdownV2';
        } elseif ($this->format === MessageFormat::HTML) {
            $result['parse_mode'] = 'HTML';
        }

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
