<?php

namespace Stezkoy\NouiTeleAudit;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use RuntimeException;

class TelegramNotifier
{
    protected ConfigRepository $config;
    protected Client $http;

    public function __construct(ConfigRepository $config)
    {
        $this->config = $config;
        $this->http = new Client(['timeout' => 10]);
    }

    public function send(string $message): void
    {
        $token = $this->config->get('stezkoy-noui-tele-audit.bot_token');
        $chatId = $this->config->get('stezkoy-noui-tele-audit.chat_id');
        $topicId = $this->config->get('stezkoy-noui-tele-audit.topic_id');

        if (!$token || !$chatId) {
            return;
        }

        $payload = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML',
        ];

        if ($topicId) {
            $payload['message_thread_id'] = (int) $topicId;
        }

        try {
            $response = $this->http->post("https://api.telegram.org/bot{$token}/sendMessage", [
                'json' => $payload,
            ]);

            $body = json_decode((string) $response->getBody(), true);

            if (!$body || !($body['ok'] ?? false)) {
                throw new RuntimeException(
                    'Telegram API error: ' . ($body['description'] ?? 'unknown error')
                );
            }
        } catch (GuzzleException $e) {
            throw new RuntimeException(
                'Failed to send Telegram notification: ' . $e->getMessage(),
                (int) $e->getCode(),
                $e
            );
        }
    }
}