<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Entity\Message;

use Botasis\Client\Telegram\Entity\InlineKeyboard\InlineKeyboardButton;
use JetBrains\PhpStorm\ArrayShape;

final readonly class Message
{
    /**
     * @param InlineKeyboardButton[][] $inlineKeyboard
     */
    public function __construct(
        public string $text,
        public MessageFormat $format,
        public string $chatId,
        public array $inlineKeyboard = [],
        public bool $disableLinkPreview = false,
    ) {
    }

    /** @psalm-suppress UndefinedAttributeClass */
    #[ArrayShape([
        'text' => "string",
        'chat_id' => "string",
        'disable_web_page_preview' => "bool",
        'parse_mode' => "string",
        'reply_markup' => "null|array"
    ])]
    public function getArray(): array
    {
        $result = [
            'text' => $this->text,
            'chat_id' => $this->chatId,
            'disable_web_page_preview' => $this->disableLinkPreview,
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

    public function withText(string $text): self
    {
        return new self(
            $text,
            $this->format,
            $this->chatId,
            $this->inlineKeyboard,
            $this->disableLinkPreview,
        );
    }

    public function withFormat(MessageFormat $format): self
    {
        return new self(
            $this->text,
            $format,
            $this->chatId,
            $this->inlineKeyboard,
            $this->disableLinkPreview,
        );
    }

    public function withChatId(string $chatId): self
    {
        return new self(
            $this->text,
            $this->format,
            $chatId,
            $this->inlineKeyboard,
            $this->disableLinkPreview,
        );
    }

    /**
     * @param InlineKeyboardButton[][] $inlineKeyboard
     */
    public function withKeyboard(array $inlineKeyboard): self
    {
        return new self(
            $this->text,
            $this->format,
            $this->chatId,
            $inlineKeyboard,
            $this->disableLinkPreview,
        );
    }

    public function withLinkPreviewDisabled(bool $disableLinkPreview): self
    {
        return new self(
            $this->text,
            $this->format,
            $this->chatId,
            $this->inlineKeyboard,
            $disableLinkPreview,
        );
    }
}
