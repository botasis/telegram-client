<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Request;

class TelegramRequest implements TelegramRequestInterface
{
    /**
     * @var callable|null $successCallback
     * @var callable|null $errorCallback
     */
    public function __construct(
        protected string $method,
        protected array $data,
        protected $successCallback = null,
        protected $errorCallback = null,
    ) {
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function onSuccess(?callable $callback): TelegramRequestInterface
    {
        $this->successCallback = $callback;

        return $this;
    }

    public function getSuccessCallback(): ?callable
    {
        return $this->successCallback;
    }

    public function onError(?callable $callback): TelegramRequestInterface
    {
        $this->errorCallback = $callback;

        return $this;
    }

    public function getErrorCallback(): ?callable
    {
        return $this->errorCallback;
    }
}
