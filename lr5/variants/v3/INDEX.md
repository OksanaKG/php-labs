# 📁 Структура проекту LR5 V3 - Путівник по файлах

## 📌 Основні документи

| Файл | Опис |
|------|------|
| **QUICK_START.md** | 🚀 Швидкий гайд з тестування (ПОЧНІТЬ З ЦЬОГО) |
| **FEATURES.md** | 🎬 Детальний опис всіх новостей |
| **CHANGELOG.md** | 📋 Повна історія змін |
| **INDEX.md** | 📁 Цей файл - навігація |

---

## 🗂️ Основна структура

```
v3/
├── 📄 index.php                          ← ТОЧКА ВХОДУ
├── 📄 diagnose.php                       ← Діагностика
│
├── 📁 classes/                           ← Основні класи
│   ├── Application.php                   ← Запуск додатку
│   ├── Router.php                        ← Маршрутизація
│   ├── Controller.php                    ← Базовий контролер
│   ├── PageController.php                ← Контролер з рендерингом
│   ├── Database.php                      ← Підключення БД (PDO)
│   ├── Request.php                       ← Обробка запитів
│   └── View.php                          ← Рендеринг views
│
├── 📁 controllers/                       ← Контролери (MVC)
│   ├── MovieController.php               ⭐ ОНОВЛЕНИЙ (9 методів)
│   │   └── Методи:
│   │       • action_list()               - таблиця фільмів
│   │       • action_gallery()            ✨ НОВИЙ
│   │       • action_detail()             ✨ НОВИЙ
│   │       • action_create()             - додати фільм
│   │       • action_edit()               - редагувати
│   │       • action_delete()             - видалити
│   │       • action_add_comment()        ✨ НОВИЙ
│   │       • action_add_reaction()       ✨ НОВИЙ
│   │       • action_vote_poll()          ✨ НОВИЙ
│   │       • action_buy_ticket()         ✨ НОВИЙ
│   │       • action_create_screening()   ✨ НОВИЙ
│   │
│   ├── ActivityController.php            ⭐ НОВИЙ КОНТРОЛЕР
│   │   └── Методи:
│   │       • action_list()               - список активностей
│   │       • action_vote()               - голосування (AJAX)
│   │       • action_create()             - додати активність (адмін)
│   │
│   ├── AuthController.php                - вхід/реєстрація
│   ├── IndexController.php               - домашня сторінка
│   ├── UploadController.php              - завантаження файлів
│   ├── GuestbookController.php           - гостьова книга
│   ├── FolderController.php              - робота з папками
│   └── SettingsController.php            - налаштування
│
├── 📁 views/                             ← PHP шаблони
│   ├── 📁 movie/
│   │   ├── list.php                      ⭐ ОНОВЛЕНИЙ
│   │   ├── create.php                    ⭐ ОНОВЛЕНИЙ (+ опис)
│   │   ├── edit.php                      ⭐ ОНОВЛЕНИЙ (+ опис)
│   │   ├── gallery.php                   ✨ НОВИЙ - сітка карток
│   │   ├── detail.php                    ✨ НОВИЙ - детальна інформація
│   │   ├── buy_ticket.php                ✨ НОВИЙ - покупка квитків
│   │   └── create_screening.php          ✨ НОВИЙ - додавання сеансу
│   │
│   ├── 📁 activity/                      ✨ НОВІЙ КАТАЛОГ
│   │   ├── list.php                      ✨ НОВИЙ - список активностей
│   │   └── create.php                    ✨ НОВИЙ - форма для адміна
│   │
│   ├── 📁 auth/                          - форми входу
│   ├── 📁 folder/                        - робота з папками
│   ├── 📁 guestbook/                     - гостьова книга
│   ├── 📁 index/                         - домашня сторінка
│   ├── 📁 settings/                      - налаштування
│   ├── 📁 upload/                        - завантаження
│   └── 📁 layout/                        - макети (header, footer)
│
├── 📁 database/
│   ├── app.db                            ← SQLite база (автоматично генерується)
│   └── schema.sql                        ⭐ ОНОВЛЕНИЙ - 15 таблиць
│
├── 📁 config/
│   ├── database.php                      ← Налаштування БД
│   └── ...
│
├── 📁 css/                               - стилі
├── 📁 data/                              - засіб даних
└── 📁 shared/                            - спільні файли
```

---

## 🔑 Ключові файли

### 1. **index.php** (Точка входу)
```php
// Ініціалізує додаток
// Завантажує toate класи (autoload)
// Запускає Application
```

### 2. **classes/Application.php** (Запуск)
```php
// Ініціалізує Router
// Ініціалізує Database (створює app.db)
// Запускає контролер на основі маршруту
```

### 3. **database/schema.sql** (Схема БД)
```sql
-- Основні таблиці
users, movies

-- Нові таблиці для курсової роботи ✨
movie_comments, movie_reactions, movie_images
movie_polls, poll_options, poll_votes
activities, activity_votes
halls, hall_seats, screenings, tickets
movie_statistics
```

### 4. **controllers/MovieController.php** (Основний контролер)
- 11 методів для управління фільмами
- Коментарі, реакції, голосування
- Покупка квитків

### 5. **controllers/ActivityController.php** (Новий контролер)
- Список активностей
- Голосування за активності
- Управління (для адміна)

---

## 🔄 Маршрути й дії

### MovieController routes:

| URL | Метод | Опис |
|-----|-------|------|
| `?route=movie/list` | GET | Таблиця фільмів |
| `?route=movie/gallery` | GET | ✨ Галерея карток |
| `?route=movie/detail&id=1` | GET | ✨ Деталь + коментарі + реакції |
| `?route=movie/create` | GET/POST | Додати фільм (адмін) |
| `?route=movie/edit&id=1` | GET/POST | Редагувати фільм (адмін) |
| `?route=movie/delete` | POST | Видалити фільм (адмін) |
| `?route=movie/add_comment` | POST | ✨ Додати коментар |
| `?route=movie/add_reaction` | POST | ✨ Додати реакцію (AJAX) |
| `?route=movie/vote_poll` | POST | ✨ Голосувати в poll (AJAX) |
| `?route=movie/buy_ticket&screening_id=1` | GET/POST | ✨ Купити квитки |
| `?route=movie/create_screening&movie_id=1` | GET/POST | ✨ Додати сеанс (адмін) |

### ActivityController routes:

| URL | Метод | Опис |
|-----|-------|------|
| `?route=activity/list` | GET | ✨ Список активностей |
| `?route=activity/vote` | POST | ✨ Голосування (AJAX) |
| `?route=activity/create` | GET/POST | ✨ Додати активність (адмін) |

---

## 💾 Таблиці БД

### Основні (раніше були):
```sql
users          (id, login, password, email, first_name, last_name, ...)
movies         (id, title, director, genre, year, duration_min) ⭐ + description
```

### Нові таблиці для курсової роботи ✨:

#### Коментарі & Реакції:
```sql
movie_comments    (id, movie_id, user_id, comment, rating, created_at)
movie_reactions   (id, movie_id, user_id, reaction_type: 'like'|'dislike')
movie_images      (id, movie_id, image_path, created_at)
```

#### Голосування:
```sql
movie_polls       (id, movie_id, question, active, created_at)
poll_options      (id, poll_id, option_text)
poll_votes        (id, poll_id, option_id, user_id, created_at)
```

#### Активності:
```sql
activities        (id, title, description, activity_type, image_path, active)
activity_votes    (id, activity_id, user_id, vote_value, created_at)
```

#### Кінотеатр:
```sql
halls             (id, name, rows, seats_per_row, created_at)
hall_seats        (id, hall_id, row_num, seat_num, is_available)
screenings        (id, movie_id, hall_id, screening_datetime, price_per_ticket)
tickets           (id, screening_id, user_id, seat_id, ticket_number, price, booking_status)
```

#### Статистика:
```sql
movie_statistics  (id, movie_id, total_comments, avg_rating, total_likes, total_votes)
```

---

## 🎨 Дизайн & Стилізація

### Колірна схема:
- 🟣 Основний: `#667eea` (в фіолет)
- 🟤 Додатковий: `#764ba2` (темний фіолет)
- ⚪ Світлий фон: `#f9f9f9`
- 🟢 Успіх: `#28a745`
- 🔴 Помилка: `#dc3545`

### Комponents:
- 📱 Mobile-first дизайн
- 💜 Card-based layout
- 🎬 Movie posters (зображення)
- 🗳️ Poll progress bars
- 🎫 Seat selection grid
- 📊 Statistics displays

---

## 🔐 Права доступу

### Адміністратор (login = 'admin'):
- ✅ Створювати/редагувати/видаляти фільми
- ✅ Додавати скріни (сеанси)
- ✅ Додавати активності
- ✅ Видаляти контент

### Звичайний користувач:
- ✅ Переглядні сторінки
- ✅ Залишати коментарі
- ✅ Додавати реакції
- ✅ Голосувати в polls
- ✅ Голосувати за активности
- ⛔ Кімати не можуть купити квитки без входу

---

## 🚀 Як запустити

```bash
# 1. Перейти в папку
cd d:\Бекенд\php-labs\lr5\variants\v3

# 2. Запустити сервер
php -S localhost:8080

# 3. Відкрити браузер
http://localhost:8080
```

---

## 🐛 Важна інформація

### При першому запуску:
1. ✅ `database/app.db` автоматично створюється
2. ✅ `schema.sql` виконується (все таблиці створюються)
3. ✅ Seed data вставляються (10 фільмів, 3 активності)

### Видалення БД:
```powershell
Remove-Item database/app.db
# При наступному запуску буде створена нова
```

---

## 📊 Статистика змін

| Параметр |값ення |
|----------|---------|
| Всього файлів додано | 6 |
| Всього файлів оновлено | 5 |
| Нових методів контролера | 9 |
| Нових таблиць БД | 12 |
| Рядків коду додано | ~2300 |
| Крайок документації | ~1500 |

---

## 📚 Посилання на документи

| Файл | Для кого |
|------|----------|
| [QUICK_START.md](QUICK_START.md) | Розробників & тестерів |
| [FEATURES.md](FEATURES.md) | Клієнтів & аналітиків |
| [CHANGELOG.md](CHANGELOG.md) | Project managers |
| [INDEX.md](INDEX.md) | Архітекторів коду |

---

## ❓ FAQ

### Q: Як увійти як адміністратор?
A: Логін `admin`. Пароль залежить від реєстрації.

### Q: Де видалити БД?
A: `database/app.db`. Видаліть, при запуску буде створена нова.

### Q: Як додати статку категорію активностей?
A: Відредагуйте массив в схємі SQL або розширьте select в view.

### Q: Чому не збальїється моя реакція?
A: Перевірте, чи увійшли ви. Реакції тільки для залігінених.

### Q: Як експортувати дані з БД?
A: Копіюйте SQL з `database/schema.sql` або експортуйте через SQLite Browser.

---

## 🎓 Навчальні цілі досягнуто ✅

- ✅ **MVC архітектура** - Application, Router, Controller, View
- ✅ **PDO & SQL** - Prepared statements, транзакції, constraints
- ✅ **AJAX** - Динамичні оновлення без перезавантаження
- ✅ **Валідація** - Фронтенд & бекенд
- ✅ **Адаптивність** - CSS Grid, mobile-first
- ✅ **Статистика** - Лічильники, графіки, звіти
- ✅ **Користувацькі ролі** - Адмін & звичайні користувачі

---

**Автор**: LR5 V3 Coursework  
**Дата**: 2026  
**Версія**: 2.0.0
