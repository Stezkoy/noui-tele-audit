<?php

namespace Stezkoy\NouiTeleAudit;

use Flarum\Foundation\AbstractServiceProvider;

class TelegramServiceProvider extends AbstractServiceProvider
{
    public function register(): void
    {
        $this->container->singleton(TelegramNotifier::class);
    }
}