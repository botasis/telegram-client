<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Request;

class TelegramRequest implements TelegramRequestInterface
{
    /**
     * @param callable|null $successCallback
     * @param callable|null $errorCallback
     * @param array<FileUpload> $files
     */
    public function __construct(
        protected string $method,
        protected array $data = [],
        protected mixed $successCallback = null,
        protected mixed $errorCallback = null,
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
