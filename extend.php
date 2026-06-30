<?php

use Flarum\Extend;
use Flarum\Flags\Event\Created;
use Flarum\User\Event\Activated;
use Flarum\User\Event\Registered;
use Stezkoy\NouiTeleAudit\TelegramServiceProvider;
use Stezkoy\NouiTeleAudit\Listeners\DiscussionFlagged;
use Stezkoy\NouiTeleAudit\Listeners\UserRegistered;
use Stezkoy\NouiTeleAudit\Listeners\EmailConfirmed;

return [
    (new Extend\ServiceProvider(TelegramServiceProvider::class)),

    (new Extend\Event)
        ->listen(Registered::class, UserRegistered::class)
        ->listen(Activated::class, EmailConfirmed::class)
        ->listen(Created::class, DiscussionFlagged::class),

    (new Extend\Locales(__DIR__ . '/locale')),
];