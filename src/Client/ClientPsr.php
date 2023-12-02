<?php

declare(strict_types=1);

namespace Botasis\Client\Telegram\Client;

use Botasis\Client\Telegram\Client\Exception\TelegramRequestException;
use Botasis\Client\Telegram\Client\Exception\TooManyRequestsException;
use Botasis\Client\Telegram\Client\Exception\WrongEntitiesException;
use Botasis\Client\Telegram\Request\TelegramRequestInterface;
use Generator;
use Http\Message\MultipartStream\MultipartStreamBuilder;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface as HttpClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final readonly class ClientPsr implements ClientInterface
{
    private MultipartStreamBuilder $multipartStreamBuilder;

    public function __construct(
        private string $token,
        private HttpClientInterface $client,
        private RequestFactoryInterface $requestFactory,
        private StreamFactoryInterface $streamFactory,
        MultipartStreamBuilder $multipartStreamBuilder,
        private string $uri = 'https://api.telegram.org',
        private LoggerInterface $logger = new NullLogger(),
    ) {
        $this->multipartStreamBuilder = clone $multipartStreamBuilder;
    }

    public function withToken(string $token): ClientInterface
    {
        return new self(
            $token,
            $this->client,
            $this->requestFactory,
            $this->streamFactory,
            $this->multipartStreamBuilder,
            $this->uri,
            $this->logger
        );
    }

    /**
     * @param TelegramRequestInterface $request
     *
     * @return array|null
     *
     * @throws ClientExceptionInterface
     * @throws JsonException
     */
    public function send(TelegramRequestInterface $request): ?array
    {
        $method = $request->getMethod();
        $this->logger->info('Sending Telegram request', ['apiMethod' => $method, 'data' => $request->getData()]);
        $uri = "$this->uri/bot$this->token/$method";
        $apiRequest = $this->requestFactory->createRequest('POST', $uri);

        if ($request->getFiles() !== []) {
            $apiRequest = $this->enrichMultipartRequest($apiRequest, $request);
        } else {
            $apiRequest = $this->enrichJsonRequest($apiRequest, $request);
        }

        $response = $this->client->sendRequest($apiRequest);
        if ($response->getStatusCode() !== 200) {
            return $this->handleError($request, $response);
        }

        /** @noinspection JsonEncodingApiUsageInspection */
        $responseDecoded = json_decode($response->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);
        if (($responseDecoded['ok'] ?? false) !== true) {
            return $this->handleError($request, $response);
        }

        return $this->handleSuccess($request, $response, $responseDecoded);
    }

    private function handleError(TelegramRequestInterface $request, ResponseInterface $response): array
    {
        $content = $response->getBody()->getContents();
        /** @noinspection JsonEncodingApiUsageInspection */
        $decoded = json_decode($content, true);
        $context = [
            'apiMethod' => $request->getMethod(),
            'data' => $request->getData(),
            'responseRaw' => $content,
            'response' => $decoded,
            'responseCode' => $response->getStatusCode(),
        ];

        $decoded = $decoded ?: [];
        $this->logger->error(
            'Telegram request error',
            $context
        );

        if ($response->getStatusCode() === 429) {
            $exception = new TooManyRequestsException('Too many requests', $response, $decoded);
        } elseif (
            is_array($decoded)
            && str_starts_with($decoded['description'] ?? '', 'Bad Request: can\'t parse entities')
        ) {
            $exception = new WrongEntitiesException($decoded['description'], $response, $decoded);
        } else {
            if (isset($decoded['description'])) {
                $message = "Telegram request error: {$decoded['description']}";
            } else {
                $message = 'Telegram request error';
            }

            $exception = new TelegramRequestException($message, $response, $decoded);
        }

        if ($request->getErrorCallback() === null) {
            throw $exception;
        }

        return $request->getErrorCallback()($response, $decoded, $exception);
    }

    private function handleSuccess(
        TelegramRequestInterface $request,
        ResponseInterface $response,
        array $responseDecoded
    ): array {
        $context = [
            'apiMethod' => $request->getMethod(),
            'data' => $request->getData(),
            'responseRaw' => $response->getBody()->getContents(),
            'response' => $responseDecoded,
            'responseCode' => $response->getStatusCode(),
        ];

        $this->logger->info(
            'Telegram response',
            $context
        );

        if ($request->getSuccessCallback() !== null) {
            $request->getSuccessCallback()($response, $responseDecoded);
        }

        return $responseDecoded;
    }

    private function enrichMultipartRequest(
        RequestInterface $apiRequest,
        TelegramRequestInterface $request,
    ): RequestInterface {
        $streamBuilder = clone $this->multipartStreamBuilder;
        foreach ($request->getFiles() as $file) {
            $streamBuilder->addResource($file->name, $file->data);
        }

        foreach ($this->getMultipartFields($request->getData()) as [$field, $contents]) {
            $streamBuilder->addResource($field, $contents);
        }

        $body = $streamBuilder->build();

        return $apiRequest
            ->withHeader(
                'Content-Type',
                'multipart/form-data; boundary=' . $streamBuilder->getBoundary() . '; charset=utf-8',
            )
            ->withHeader('Content-Length', (string)$body->getSize())
            ->withBody($body);
    }

    private function enrichJsonRequest(
        RequestInterface $apiRequest,
        TelegramRequestInterface $request,
    ): RequestInterface {
        if ($request->getData() === []) {
            return $apiRequest;
        }

        $content = json_encode($request->getData(), JSON_THROW_ON_ERROR);
        $body = $this->streamFactory->createStream($content);

        return $apiRequest
            ->withHeader('Content-Length', (string)$body->getSize())
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withBody($body);
    }

    /**
     * @return Generator<string, string>
     */
    private function getMultipartFields(array $data): Generator
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value, JSON_THROW_ON_ERROR);
                yield [(string)$key, $value];
            } else {
                yield [(string)$key, (string)$value];
            }
        }
    }
}
