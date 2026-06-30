# NOUI Telegram Audit

[Русская версия](README_RU.md)

Flarum v2 extension that sends Telegram notifications for moderation and audit events.

## Features

- **New user registration** — notifies when a new user registers on the forum
- **Email confirmation** — notifies when a user confirms their email
- **Discussion flagged** — notifies when a discussion is flagged
- **Multilingual** — English, Russian, German, French, Turkish, Italian, Chinese, Polish

## Installation

```bash
composer require stezkoy/noui-tele-audit
php flarum cache:clear
```

## Configuration

Add the following to your `config.php`:

```php
<?php return array(
    'stezkoy-noui-tele-audit' => array(
        'token' => '1234567890:AAF1Cc2Dd3Ee4Ff5Gg6Hh7Ii8Jj9Kk0Ll',
        'chat_id' => '-1001234567890',
        'topic_id' => '123', // optional — send to a specific topic within a group
        'notify_on_register' => true,
        'notify_on_email_confirmed' => true,
        'notify_on_flag' => true,
    ),
);
```

- `token` — Telegram bot token from [@BotFather](https://t.me/BotFather)
- `chat_id` — Chat ID to send messages to
- `topic_id` — (optional) Topic ID to send messages to a specific topic in a group
- `notify_on_register` — enable/disable registration notifications (default: true)
- `notify_on_email_confirmed` — enable/disable email confirmation notifications (default: true)
- `notify_on_flag` — enable/disable discussion flag notifications (default: true)


## License

GPL-3.0
