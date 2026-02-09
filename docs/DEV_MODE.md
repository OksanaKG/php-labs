# Development Mode

## Hot Reload

Сторінки автоматично оновлюються при зміні PHP/CSS файлів.

### Як працює

1. JavaScript на сторінці опитує `/?_dev_check=1` кожні 4 секунди
2. Сервер повертає хеш часу модифікації всіх файлів
3. Якщо хеш змінився — сторінка перезавантажується

### Коли активний

Hot reload працює тільки в dev режимі:
- `localhost` або `127.0.0.1`
- Або змінна середовища `PHP_ENV=development`

### Інтеграція

```php
// На початку index.php
require_once __DIR__ . '/shared/helpers/dev_reload.php';
handleDevReloadRequest();

// Перед </body>
<?= devReloadScript() ?>
```

### Файли що відслідковуються

- `.php` — PHP файли
- `.css` — стилі

### Налаштування інтервалу

```php
<?= devReloadScript(2000) ?>  // Перевірка кожні 2 секунди
```

---

## Запуск сервера

```bash
php -S localhost:8000
```

Відкрийте http://localhost:8000 — hot reload активний автоматично.
