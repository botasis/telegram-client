<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Request;

/**
 * Request entity for the approveChatJoinRequest
 * @see https://core.telegram.org/bots/api#approvechatjoinrequest
 */
final class JoinRequestApproval extends TelegramRequest
{
    /**
     * @param string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string $userId Unique identifier of the target user
     */
    public function __construct(
        string $chatId,
        string $userId,
        ?callable $successCallback = null,
        ?callable $errorCallback = null,
    ) {
        parent::__construct(
            'approveChatJoinRequest',
            [
                'chat_id' => $chatId,
                'user_id' => $userId,
            ],
            $successCallback,
            $errorCallback
        );
    }
}
