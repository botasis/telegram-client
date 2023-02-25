<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Entity\Message;

enum MessageFormat: int
{
    case TEXT = 1;
    case MARKDOWN = 2;
    case HTML = 3;
}
