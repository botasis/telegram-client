<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Request;

use Psr\Http\Message\StreamInterface;

final readonly class FileUpload
{
    /**
     * @param string|resource|StreamInterface $data
     */
    public function __construct(
        public string $name,
        public mixed $data,
    ) {
    }
}
