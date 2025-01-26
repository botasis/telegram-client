<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Request\Message;

use Botasis\Client\Telegram\Request\InlineKeyboard\InlineKeyboardButton;
use Botasis\Client\Telegram\Request\TelegramRequest;
use JetBrains\PhpStorm\ArrayShape;

final class Message extends TelegramRequest
{
    /**
     * @param InlineKeyboardButton[][] $inlineKeyboard
     */
    public function __construct(
        public readonly string $text,
        public readonly MessageFormat $format,
        public readonly string $chatId,
        public readonly array $inlineKeyboard = [],
        public readonly bool $disableLinkPreview = false,
        public readonly ?string $replyToMessageId  = null,
        ?callable $successCallback = null,
        ?callable $errorCallback = null,
    ) {
        parent::__construct('sendMessage', $this->createData(), $successCallback, $errorCallback);
    }

    public function withText(string $text): self
    {
        return new self(
            $text,
            $this->format,
            $this->chatId,
            $this->inlineKeyboard,
            $this->disableLinkPreview,
            $this->replyToMessageId,
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
            $this->inlineKeyboard,
            $this->disableLinkPreview,
            $this->replyToMessageId,
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
            $this->inlineKeyboard,
            $this->disableLinkPreview,
            $this->replyToMessageId,
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
            $inlineKeyboard,
            $this->disableLinkPreview,
            $this->replyToMessageId,
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
            $this->inlineKeyboard,
            $disableLinkPreview,
            $this->replyToMessageId,
            $this->successCallback,
            $this->errorCallback,
        );
    }

    /** @psalm-return array{
     *     text: string,
     *     chat_id: string,
     *     disable_web_page_preview: bool,
     *     parse_mode?: string,
     *     reply_markup?: array,
     *     reply_to_message_id?: string,
     * }
     **/
    private function createData(): array
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
                $result['reply_markup']['inline_keyboard'][$i][] = $button->getData();
            }
        }

        if ($this->replyToMessageId !== null) {
            $result['reply_to_message_id'] = $this->replyToMessageId;
        }

        return $result;
    }
}
