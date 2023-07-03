<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Request\Message;

use Botasis\Client\Telegram\Request\InlineKeyboard\InlineKeyboardButton;
use Botasis\Client\Telegram\Request\TelegramRequest;

/**
 * A common class for message updating. It doesn't support inline_message_id and entities/caption_entities keys
 *
 * @see https://core.telegram.org/bots/api#editmessagetext
 * @see https://core.telegram.org/bots/api#editmessagecaption
 */
final class MessageUpdate extends TelegramRequest
{
    /**
     * @param bool $caption If true, uses editMessageCaption method, editMessageText otherwise
     * @param InlineKeyboardButton[][] $inlineKeyboard
     */

    public function __construct(
        public readonly string $text,
        public readonly MessageFormat $format,
        public readonly string $chatId,
        public readonly string $messageId,
        public readonly bool $caption = false,
        public readonly array $inlineKeyboard = [],
        public readonly bool $disableLinkPreview = false,
        ?callable $successCallback = null,
        ?callable $errorCallback = null,
    ) {
        parent::__construct(
            $this->caption ? 'editMessageCaption' : 'editMessageText',
            $this->createData(),
            $successCallback,
            $errorCallback
        );
    }

    public function withText(string $text): self
    {
        return new self(
            $text,
            $this->format,
            $this->chatId,
            $this->messageId,
            $this->caption,
            $this->inlineKeyboard,
            $this->disableLinkPreview,
            $this->successCallback,
            $this->errorCallback,
        );
    }

    public function withFormat(MessageFormat $format): self
    {
        return new self(
            $this->text,
            $format,
            $this->chatId,
            $this->messageId,
            $this->caption,
            $this->inlineKeyboard,
            $this->disableLinkPreview,
            $this->successCallback,
            $this->errorCallback,
        );
    }

    public function withChatId(string $chatId): self
    {
        return new self(
            $this->text,
            $this->format,
            $chatId,
            $this->messageId,
            $this->caption,
            $this->inlineKeyboard,
            $this->disableLinkPreview,
            $this->successCallback,
            $this->errorCallback,
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
            $this->messageId,
            $this->caption,
            $inlineKeyboard,
            $this->disableLinkPreview,
            $this->successCallback,
            $this->errorCallback,
        );
    }

    public function withMessageId(string $messageId): self
    {
        return new self(
            $this->text,
            $this->format,
            $this->chatId,
            $messageId,
            $this->caption,
            $this->inlineKeyboard,
            $this->disableLinkPreview,
            $this->successCallback,
            $this->errorCallback,
        );
    }

    public function withLinkPreviewDisabled(bool $disableLinkPreview): self
    {
        return new self(
            $this->text,
            $this->format,
            $this->chatId,
            $this->messageId,
            $this->caption,
            $this->inlineKeyboard,
            $disableLinkPreview,
            $this->successCallback,
            $this->errorCallback,
        );
    }

    private function createData(): array
    {
        $textKey = $this->caption ? 'caption' : 'text';
        $result = [
            $textKey => $this->text,
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
