<?php

namespace Stezkoy\NouiTeleAudit;

use GuzzleHttp\Client;
use Illuminate\Contracts\Config\Repository as ConfigRepository;

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

        $this->http->post("https://api.telegram.org/bot{$token}/sendMessage", [
            'json' => $payload,
        ]);
    }
}