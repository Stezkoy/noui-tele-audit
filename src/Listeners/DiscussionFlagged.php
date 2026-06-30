<?php

namespace Stezkoy\NouiTeleAudit\Listeners;

use Flarum\Flags\Event\Created;
use Stezkoy\NouiTeleAudit\TelegramNotifier;

class DiscussionFlagged
{
    protected TelegramNotifier $notifier;

    public function __construct(
        TelegramNotifier $notifier,
    ) {
        $this->notifier = $notifier;
    }

    public function handle(Created $event): void
    {
        $flag = $event->flag;
        $discussion = $flag->post->discussion;

        $message = "Discussion flagged: {$discussion->title}";

        $this->notifier->send($message);
    }
}