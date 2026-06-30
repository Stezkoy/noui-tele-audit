<?php

namespace Stezkoy\NouiTeleAudit;

use Flarum\Foundation\Config;
use RuntimeException;

class TelegramNotifier
{
    protected Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function send(string $message): array
    {
        $cfg = $this->config->offsetGet('stezkoy-noui-tele-audit');
        $token = $cfg['bot_token'] ?? null;
        $chatId = $cfg['chat_id'] ?? null;
        $topicId = $cfg['topic_id'] ?? null;

        if (!$token || !$chatId) {
            return ['ok' => false, 'description' => 'Missing bot_token or chat_id'];
        }

        $payload = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML',
        ];

        if ($topicId) {
            $payload['message_thread_id'] = (int) $topicId;
        }

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => json_encode($payload),
                'timeout' => 10,
            ],
        ];

        $context = stream_context_create($options);
        $result = @file_get_contents($url, false, $context);

        if ($result === false) {
            throw new RuntimeException('Failed to send Telegram notification: network error');
        }

        $body = json_decode($result, true);

        if (!$body || !($body['ok'] ?? false)) {
            throw new RuntimeException(
                'Telegram API error: ' . ($body['description'] ?? 'unknown error')
            );
        }

        return $body;
    }
}