# NOUI Telegram Audit

[English version](README.md)

Расширение для Flarum v2, отправляющее уведомления в Telegram о событиях модерации и аудита.

## Возможности

- **Регистрация нового пользователя** — уведомление при регистрации на форуме
- **Подтверждение email** — уведомление при подтверждении email пользователем
- **Жалоба на тему** — уведомление при подаче жалобы на тему
- **8 языков** — русский, английский, немецкий, французский, турецкий, итальянский, китайский, польский


## Установка

```bash
composer require stezkoy/noui-tele-audit
php flarum cache:clear
```

## Настройка

Добавьте в `config.php`:

```php
    'stezkoy-noui-tele-audit' => array(
        'bot_token' => '1234567890:AAF1Cc2Dd3Ee4Ff5Gg6Hh7Ii8Jj9Kk0Ll',
        'chat_id' => '-1001234567890',
        'topic_id' => '123', // опционально — отправлять в конкретную тему группы
        'notify_on_register' => true,
        'notify_on_email_confirmed' => true,
        'notify_on_flag' => true,
    ),
```

- `token` — токен бота Telegram от [@BotFather](https://t.me/BotFather)
- `chat_id` — ID чата для отправки сообщений
- `topic_id` — (опционально) ID темы для отправки сообщений в конкретную тему группы
- `notify_on_register` — вкл/выкл уведомления о регистрации (по умолчанию: true)
- `notify_on_email_confirmed` — вкл/выкл уведомления о подтверждении email (по умолчанию: true)
- `notify_on_flag` — вкл/выкл уведомления о жалобах (по умолчанию: true)

## Лицензия

GPL-3.0
