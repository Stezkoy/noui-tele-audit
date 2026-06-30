<?php

namespace Stezkoy\NouiTeleAudit\Listeners;

use Flarum\User\Event\Registered;
use Stezkoy\NouiTeleAudit\TelegramNotifier;

class UserRegistered
{
    protected TelegramNotifier $notifier;

    public function __construct(
        TelegramNotifier $notifier,
    ) {
        $this->notifier = $notifier;
    }

    public function handle(Registered $event): void
    {
        $user = $event->user;

        $message = "New user registered: {$user->display_name} ({$user->email})";

        $this->notifier->send($message);
    }
}