<?php

namespace Stezkoy\NouiTeleAudit\Listeners;

use Flarum\Locale\Translator;
use Flarum\User\Event\Registered;
use Stezkoy\NouiTeleAudit\TelegramConfig;
use Stezkoy\NouiTeleAudit\TelegramNotifier;

class UserRegistered
{
    protected TelegramNotifier $notifier;
    protected Translator $translator;
    protected TelegramConfig $config;

    public function __construct(
        TelegramNotifier $notifier,
        Translator $translator,
        TelegramConfig $config,
    ) {
        $this->notifier = $notifier;
        $this->translator = $translator;
        $this->config = $config;
    }

    public function handle(Registered $event): void
    {
        if (!$this->config->notifyOnRegister()) {
            return;
        }

        $user = $event->user;

        $message = $this->translator->trans('stezkoy-noui-tele-audit.messages.user_registered', [
            '{username}' => $user->display_name,
            '{email}' => $user->email,
        ]);

        $this->notifier->send($message);
    }
}