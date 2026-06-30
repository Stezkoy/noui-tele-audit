<?php

namespace Stezkoy\NouiTeleAudit;

use Flarum\Foundation\Config;

class TelegramConfig
{
    protected Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function botToken(): ?string
    {
        $cfg = $this->config->offsetGet('stezkoy-noui-tele-audit');
        return $cfg['bot_token'] ?? null;
    }

    public function chatId(): ?string
    {
        $cfg = $this->config->offsetGet('stezkoy-noui-tele-audit');
        return $cfg['chat_id'] ?? null;
    }

    public function topicId(): ?string
    {
        $cfg = $this->config->offsetGet('stezkoy-noui-tele-audit');
        return $cfg['topic_id'] ?? null;
    }

    public function notifyOnRegister(): bool
    {
        $cfg = $this->config->offsetGet('stezkoy-noui-tele-audit');
        return $cfg['notify_on_register'] ?? true;
    }

    public function notifyOnEmailConfirmed(): bool
    {
        $cfg = $this->config->offsetGet('stezkoy-noui-tele-audit');
        return $cfg['notify_on_email_confirmed'] ?? true;
    }

    public function notifyOnFlag(): bool
    {
        $cfg = $this->config->offsetGet('stezkoy-noui-tele-audit');
        return $cfg['notify_on_flag'] ?? true;
    }
}