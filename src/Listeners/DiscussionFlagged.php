<?php

namespace Stezkoy\NouiTeleAudit\Listeners;

use Flarum\Flags\Event\Created;
use Flarum\Locale\Translator;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Stezkoy\NouiTeleAudit\TelegramNotifier;

class DiscussionFlagged
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

    public function handle(Created $event): void
    {
        if (!$this->config->get('stezkoy-noui-tele-audit.notify_on_flag', true)) {
            return;
        }

        $flag = $event->flag;
        $discussion = $flag->post->discussion;

        $message = $this->translator->trans(
            'stezkoy-noui-tele-audit.messages.discussion_flagged',
            [
                'discussion_title' => $discussion->title,
            ]
        );

        $this->notifier->send($message);
    }
}