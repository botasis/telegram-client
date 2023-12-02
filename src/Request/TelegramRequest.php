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
        protected array $data = [],
        protected $successCallback = null,
        protected $errorCallback = null,
        protected array $files = [],
    ) {
        $this->extractFiles($this->data);
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

    public function addFiles(FileUpload ...$files): self
    {
        $this->files = array_merge($this->files, $files);

        return $this;
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    private function extractFiles(array &$data): void
    {
        $files = [];
        foreach ($data as $key => $value) {
            if ($value instanceof FileUpload) {
                $files[] = $value;
                $data[$key] = "attach://$value->name";
            } elseif (is_array($value)) {
                $this->extractFiles($value);
                $data[$key] = $value;
            }
        }

        if ($files !== []) {
            $this->addFiles(...$files);
        }
    }
}
