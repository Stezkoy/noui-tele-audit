<?php

namespace Stezkoy\NouiTeleAudit\Listeners;

use Flarum\User\Event\Activated;
use Stezkoy\NouiTeleAudit\TelegramNotifier;

class EmailConfirmed
{
    protected TelegramNotifier $notifier;

    public function __construct(
        TelegramNotifier $notifier,
    ) {
        $this->notifier = $notifier;
    }

    public function handle(Activated $event): void
    {
        $user = $event->user;

        $message = "Email confirmed: {$user->display_name} ({$user->email})";

        $this->notifier->send($message);
    }
}