<?php

namespace Stezkoy\NouiTeleAudit\Listeners;

use Flarum\Flags\Event\Created;
use Flarum\Locale\Translator;
use Stezkoy\NouiTeleAudit\TelegramConfig;
use Stezkoy\NouiTeleAudit\TelegramNotifier;

class DiscussionFlagged
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

    public function handle(Created $event): void
    {
        if (!$this->config->notifyOnFlag()) {
            return;
        }

        $flag = $event->flag;
        $discussion = $flag->post->discussion;

        $message = $this->translator->trans('stezkoy-noui-tele-audit.messages.discussion_flagged', [
            '{discussion_title}' => $discussion->title,
        ]);

        $this->notifier->send($message);
    }
}