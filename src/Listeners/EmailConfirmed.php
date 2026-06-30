<?php

namespace Stezkoy\NouiTeleAudit\Listeners;

use Flarum\Locale\Translator;
use Flarum\User\Event\Activated;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Stezkoy\NouiTeleAudit\TelegramNotifier;

class EmailConfirmed
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

    public function handle(Activated $event): void
    {
        if (!$this->config->get('stezkoy-noui-tele-audit.notify_on_email_confirmed', true)) {
            return;
        }

        $user = $event->user;

        $message = $this->translator->trans(
            'stezkoy-noui-tele-audit.messages.email_confirmed',
            [
                'username' => $user->display_name,
                'email' => $user->email,
            ]
        );

        $this->notifier->send($message);
    }
}