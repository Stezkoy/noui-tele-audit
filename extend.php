<?php

use Flarum\Extend;
use Flarum\Flags\Event\Created;
use Flarum\User\Event\Activated;
use Flarum\User\Event\Registered;
use Stezkoy\NouiTeleAudit\Listeners\DiscussionFlagged;
use Stezkoy\NouiTeleAudit\Listeners\EmailConfirmed;
use Stezkoy\NouiTeleAudit\Listeners\UserRegistered;

return [
    (new Extend\Event)
        ->listen(Registered::class, UserRegistered::class)
        ->listen(Activated::class, EmailConfirmed::class)
        ->listen(Created::class, DiscussionFlagged::class),

    (new Extend\Locales(__DIR__ . '/locale')),
];