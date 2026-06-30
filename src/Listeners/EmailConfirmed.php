<?php

namespace Stezkoy\NouiTeleAudit\Listeners;

use Flarum\Http\UrlGenerator;
use Flarum\Locale\Translator;
use Flarum\User\Event\Activated;
use Stezkoy\NouiTeleAudit\TelegramConfig;
use Stezkoy\NouiTeleAudit\TelegramNotifier;

class EmailConfirmed
{
    protected TelegramNotifier $notifier;
    protected Translator $translator;
    protected TelegramConfig $config;
    protected UrlGenerator $url;

    public function __construct(
        TelegramNotifier $notifier,
        Translator $translator,
        TelegramConfig $config,
        UrlGenerator $url,
    ) {
        $this->notifier = $notifier;
        $this->translator = $translator;
        $this->config = $config;
        $this->url = $url;
    }

    public function handle(Activated $event): void
    {
        if (!$this->config->notifyOnEmailConfirmed()) {
            return;
        }

        $user = $event->user;

        $message = $this->translator->trans('stezkoy-noui-tele-audit.messages.email_confirmed', [
            '{username}' => $user->display_name,
            '{email}' => $user->email,
            '{profile_url}' => $this->url->to('forum')->route('user', ['username' => $user->username]),
        ]);

        $this->notifier->send($message);
    }
}