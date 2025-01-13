# Botasis Telegram Bot API Client

## Overview

**Botasis** offers a lightweight and strictly PSR-compliant implementation of the [Telegram Bot API](https://core.telegram.org/bots/api). Designed for developers seeking a robust and advanced bot SDK, **Botasis** simplifies the creation and management of Telegram bots.

Explore our advanced SDK at [botasis/runtime](https://github.com/botasis/runtime) and access a ready-to-deploy application template at [botasis/bot-template](https://github.com/botasis/bot-template).

## Quick Start

Ensure you have [Composer](https://getcomposer.org/doc/00-intro.md) installed and a bot token from [BotFather](https://core.telegram.org/bots/features#creating-a-new-bot).

### Setup

1. **Install the Package:**
   ```shell
   composer require botasis/telegram-client
   ```

2. **Install PSR HTTP Client and Message Factory:**
   If you don't have preferences, use:
   ```shell
   composer require httpsoft/http-message php-http/socket-client
   ```

3. **Create an API Client Instance:**
   Either use your DI container or manually instantiate:
   ```php
   $streamFactory = new \HttpSoft\Message\StreamFactory();
   $client = new \Botasis\Client\Telegram\Client\ClientPsr(
       getenv('BOT_TOKEN'),
       new \Http\Client\Socket\Client(),
       new \HttpSoft\Message\RequestFactory(),
       $streamFactory,
       new \Http\Message\MultipartStream\MultipartStreamBuilder($streamFactory),
   );
   ```

4. **Send a Request:**
   Example to send a "Hello" message:
   ```php
   $response = $client->send(new \Botasis\Client\Telegram\Request\TelegramRequest(
       'sendMessage', // any telegram bot api method you like
       // data to send
       [
           'text' => 'Hello Botasis!',
           'chat_id' => $chatId,
       ]
   ));
   ```

   `$response` will contain the Telegram Bot API response data. Refer to the [API specification](https://core.telegram.org/bots/api) for details.

## Feature Highlights

### Method-Specific Request Classes
Utilize strictly-typed classes for API requests. For instance:
```php
$requestTyped = new \Botasis\Client\Telegram\Request\Message\Message(
    'Hello *Botasis*\!', // be sure you correctly escape special characters when use Markdown message format
    \Botasis\Client\Telegram\Request\Message\MessageFormat::MARKDOWN,
    $chatId,
);

// This is equal, but not strictly typed request:
$requestGeneric = new \Botasis\Client\Telegram\Request\TelegramRequest(
        'sendMessage',
        [
            'text' => 'Hello *Botasis*\!',
            'chat_id' => $chatId,
            'parse_mode' => 'MarkdownV2',
        ]
    )
```

### Extending Functionality
Missing a method-specific request class? Extend the library:
- **Contribute**: Submit a PR with your implementation.
- **Fallback**: Use the generic `TelegramRequest` class.

This approach ensures immediate adaptability to any Telegram API updates.

## Files uploading
*Documentation in progress – stay tuned!*

## Error Handling
*Documentation in progress – stay tuned!*
