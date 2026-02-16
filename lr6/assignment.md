# Лабораторна робота №6

**Тема:** Знайомство з Laravel. Встановлення, конфігурація, робота з БД та HTTP. Eloquent ORM, Auth, CRUD.

## Частина 1 — Базовий додаток

### 1. Встановлення Laravel

- PHP, Composer, Laravel installer
- Запустити на локальній машині

### 2. Конфігурація

- `.env` файл: порт, DEBUG_MODE, підключення до БД, логін/пароль root

### 3. Робота з БД

- Eloquent ORM
- Створити БД, підключити додаток

### 4. Створення додатку

| Вимога | Деталі |
|--------|--------|
| Auth | Вхід як адміністратор (Laravel starter kit, без реєстрації) |
| Seed | `admin@admin.com` / `password` |
| CRUD | Users + Products |
| Users | ПІБ (required), email, password, вік, роль, телефон |
| Products | Назва (required), категорія (list), ціна, опис, зображення (min 100x100) |
| Міграції | Для створення схем |
| Зображення | `storage/app/public` + symlink |
| Контролери | Resource controllers (index, create, store...) |

## Частина 2 — Розширений функціонал

| Вимога | Деталі |
|--------|--------|
| Invoices | ID, UserID (FK), ProductID (FK), дата, к-ть товару, сума |
| Валідація | Request-класи |
| Пагінація | 10 записів на сторінку (Users/Products/Invoices) |
| Datatables | Datatables.net (з/без серверного рендерингу) |
| Email | SMTP (Mailgun/Mailtrap) — лист при створенні користувача |
| i18n | `resources/lang` — багатомовність |
| Тема | AdminLTE або аналог |

## Корисні посилання

- [Laravel Documentation](https://laravel.com/docs) — офіційна документація
- [Laravel Eloquent ORM](https://laravel.com/docs/eloquent) — робота з БД
- [Laravel Migrations](https://laravel.com/docs/migrations) — міграції
- [Laravel Controllers](https://laravel.com/docs/controllers) — контролери
- [Laravel Blade Templates](https://laravel.com/docs/blade) — шаблони Blade
- [Laravel Authentication](https://laravel.com/docs/authentication) — авторизація
- [Laravel Validation](https://laravel.com/docs/validation) — валідація
- [Laravel Pagination](https://laravel.com/docs/pagination) — пагінація
- [Laravel Mail](https://laravel.com/docs/mail) — email
- [Laravel Localization](https://laravel.com/docs/localization) — багатомовність
