<?php

namespace Stezkoy\NouiTeleAudit\Listeners;

use Flarum\Locale\Translator;
use Flarum\User\Event\Registered;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Stezkoy\NouiTeleAudit\TelegramNotifier;

class UserRegistered
{
    protected TelegramNotifier $notifier;
    protected ConfigRepository $config;
    protected Translator $translator;

    public function __construct(
        TelegramNotifier $notifier,
        ConfigRepository $config,
        Translator $translator
    ) {
        $this->notifier = $notifier;
        $this->config = $config;
        $this->translator = $translator;
    }

    public function handle(Registered $event): void
    {
        if (!$this->config->get('stezkoy-noui-tele-audit.notify_on_register', true)) {
            return;
        }

        $user = $event->user;

        $message = $this->translator->trans(
            'stezkoy-noui-tele-audit.messages.user_registered',
            [
                'username' => $user->display_name,
                'email' => $user->email,
            ]
        );

        $this->notifier->send($message);
    }
}