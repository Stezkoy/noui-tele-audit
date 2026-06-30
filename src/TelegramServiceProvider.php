<?php

namespace Stezkoy\NouiTeleAudit;

use Flarum\Foundation\AbstractServiceProvider;
use Illuminate\Contracts\Config\Repository as ConfigRepository;

class TelegramServiceProvider extends AbstractServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(TelegramNotifier::class, function () {
            return new TelegramNotifier(
                $this->app->make(ConfigRepository::class)
            );
        });
    }
}