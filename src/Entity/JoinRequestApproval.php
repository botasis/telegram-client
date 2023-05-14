<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Entity;

/**
 * Request entity for the approveChatJoinRequest
 * @see https://core.telegram.org/bots/api#approvechatjoinrequest
 */
final readonly class JoinRequestApproval
{
    /**
     * @param string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string $userId Unique identifier of the target user
     */
    public function __construct(
        public string $chatId,
        public string $userId,
    ) {
    }
}
