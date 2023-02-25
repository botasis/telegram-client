<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Entity;

final readonly class CallbackResponse
{
    public function __construct(
        public string $id,
        public ?string $text = null,
        public bool $showAlert = false,
        public ?string $url = null,
        public int $cacheTime = 0,
    ) {
    }
}
