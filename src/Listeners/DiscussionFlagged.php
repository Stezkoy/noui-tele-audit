<?php

namespace Stezkoy\NouiTeleAudit\Listeners;

use Flarum\Flags\Event\Created;
use Flarum\Http\UrlGenerator;
use Flarum\Locale\Translator;
use Stezkoy\NouiTeleAudit\TelegramConfig;
use Stezkoy\NouiTeleAudit\TelegramNotifier;

class DiscussionFlagged
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

    public function handle(Created $event): void
    {
        if (!$this->config->notifyOnFlag()) {
            return;
        }

        $flag = $event->flag;
        $discussion = $flag->post->discussion;

        $message = $this->translator->trans('stezkoy-noui-tele-audit.messages.discussion_flagged', [
            '{discussion_title}' => $discussion->title,
            '{discussion_url}' => $this->url->to('forum')->route('discussion', ['id' => $discussion->id]),
        ]);

        $this->notifier->send($message);
    }
}