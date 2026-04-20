# Кінотеатральна система v3 - Керсова робота

## 🎬 Нові функціональності

Цей проект розширює базову CRUD-систему фільмів наступними компонентами:

### 1. 📸 **Галерея фільмів**
- **Маршрут**: `/index.php?route=movie/gallery`
- Відображення фільмів як красивих карток з постерами
- Затискання на фільм для перегляду детальної інформації
- Статистика коментарів та реакцій на карточці

### 2. 💬 **Система коментарів**
- **Маршрут**: `/index.php?route=movie/detail&id=<ID>`
- Користувачі можуть залишати коментарі до фільмів
- Рейтинг фільму (1-10 зірок)
- Автоматичне оновлення коментаря (заміна старого на новий від того ж користувача)
- Відображення імені, прізвища і дати коментаря

### 3. 👍 **Система реакцій**
- Кнопки "Мне нравится" (like) та "Не нравится" (dislike)
- Користувач може змінити свою реакцію
- Лічильник всіх реакцій на фільм
- AJAX-запити для швидкого оновлення без перезавантаженням

### 4. 🗳️ **Система голосувань (Polls)**
- Адміністратор може створювати опитування для кожного фільму
- Користувачі голосують за варіанти
- Графіки з прогресс-барами показують відсоток голосів
- Таблиці: `movie_polls`, `poll_options`, `poll_votes`

### 5. ❤️ **Активності кінотеатру**
- **Маршрут**: `/index.php?route=activity/list`
- Голосування за кінематографічні активності (благодійні фільми, тощо)
- Три типи активностей: 
  - ❤️ Благодійна (charity)
  - 🎈 Дитяча (kids)
  - 🎪 Спеціальна (special)
- Toggle-голосування (одне голосування на користувача)
- Статистика голосів

### 6. 🎫 **Система покупки квитків**
- **Маршрут**: `/index.php?route=movie/buy_ticket&screening_id=<ID>`
- Вибір місць у залі (інтерактивна сітка)
- Передача забронених місць
- Генерація унікальних номерів квитків
- Розрахунок загальної суми
- Таблиці: `screenings`, `tickets`, `hall_seats`, `halls`

### 7. 🎭 **Сеанси (Screenings)**
- **Маршрут**: `/index.php?route=movie/create_screening?movie_id=<ID>`
- Адміністратор може створювати сеанси для фільмів
- Вибір залі, дати/часу та ціни
- Автоматичний список сеансів на сторінці детальної інформації про фільм

### 8. 📊 **Статистика фільмів**
- Таблиця `movie_statistics` для кешування статистики
- Кількість коментарів
- Середня оцінка
- Кількість лайків
- Кількість голосів в опитуваннях

---

## 🛢️ База даних (SQLite)

### Нові таблиці:

```sql
-- Основні таблиці (користувачі та фільми)
users
movies

-- Коментарі та реакції
movie_comments (movie_id, user_id, comment, rating)
movie_reactions (movie_id, user_id, reaction_type: 'like'|'dislike')
movie_images (movie_id, image_path)

-- Голосування
movie_polls (movie_id, question, active)
poll_options (poll_id, option_text)
poll_votes (poll_id, option_id, user_id)

-- Активності
activities (title, description, activity_type, image_path)
activity_votes (activity_id, user_id, vote_value)

-- Кінотеатр
halls (name, rows, seats_per_row)
hall_seats (hall_id, row_num, seat_num, is_available)
screenings (movie_id, hall_id, screening_datetime, price_per_ticket)
tickets (screening_id, user_id, seat_id, ticket_number, price)

-- Статистика
movie_statistics (movie_id, total_comments, avg_rating, total_likes, total_votes)
```

### Таблиці можна експортувати як SQL:
1. Використовуйте SQLite інструменти для експорту
2. Або скопіюйте схему з `database/schema.sql`

---

## 🗂️ Структура проекту

```
v3/
├── classes/
│   ├── Application.php
│   ├── Controller.php
│   ├── Database.php
│   ├── PageController.php
│   ├── Router.php
│   └── Request.php
├── controllers/
│   ├── MovieController.php    (додані нові методи)
│   ├── ActivityController.php (НОВИЙ)
│   ├── AuthController.php
│   ├── UploadController.php
│   └── ...
├── views/
│   ├── movie/
│   │   ├── list.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   ├── gallery.php        (НОВИЙ)
│   │   ├── detail.php         (НОВИЙ)
│   │   ├── buy_ticket.php     (НОВИЙ)
│   │   └── create_screening.php (НОВИЙ)
│   ├── activity/
│   │   ├── list.php           (НОВИЙ)
│   │   └── create.php         (НОВИЙ)
│   └── ...
├── database/
│   ├── app.db                 (SQLite база)
│   └── schema.sql             (схема всіх таблиць)
└── index.php
```

---

## 🚀 Як запустити

### 1. Видалити старий файл бази даних
```bash
rm database/app.db
```

### 2. Запустити PHP DevServer
```bash
cd path/to/lr5/variants/v3
php -S localhost:8080
```

### 3. Відкрити в браузері
```
http://localhost:8080
```

### 4. Тестування функцій

#### Адміністратор:
- Логін: `admin`
- Пароль: (залежить від вашої налаштування)
- Може: створювати/редагувати фільми, створювати сеанси, додавати активності, керувати залами

#### Звичайний користувач:
- Залишає коментарі
- Додає реакції (like/dislike)
- Голосує у опитуваннях
- Голосує за активності
- Купує квитки

---

## 📋 Дії контролерів

### MovieController
- `action_list()` - список фільмів у таблиці
- `action_gallery()` - **НОВИЙ** галерея фільмів
- `action_detail()` - **НОВИЙ** детальна сторінка з коментарями, реакціями, опитуваннями
- `action_create()` - додати фільм
- `action_edit()` - редагувати фільм
- `action_delete()` - видалити фільм
- `action_add_comment()` - **НОВИЙ** додати коментар
- `action_add_reaction()` - **НОВИЙ** додати реакцію (AJAX)
- `action_vote_poll()` - **НОВИЙ** голосувати в опитуванні (AJAX)
- `action_buy_ticket()` - **НОВИЙ** купити квитки та вибрати місця
- `action_create_screening()` - **НОВИЙ** створити сеанс (тільки адмін)

### ActivityController (НОВИЙ)
- `action_list()` - список активностей кінотеатру
- `action_vote()` - голосувати за активність (AJAX)
- `action_create()` - додати нову активність (тільки адмін)

---

## 🎨 Стилізація

Всі нові компоненти мають:
- Адаптивний та сучасний дизайн
- Вбудований CSS в шаблони
- Гарне оформлення карток, форм та інтерактивних елементів
- Emoji для візуалізації

---

## 🔐 Безпека

- Всі дані валідуються
- Використовуються prepared statements (PDO)
- HTML-екранування для XSS-захисту
- Доступ до адміністраторського функціоналу обмежений

---

## 📝 Зміни в файлах

### Оновлені файли:
- `database/schema.sql` - 12 нових таблиць
- `controllers/MovieController.php` - додані 6 нових методів
- `views/movie/create.php` - додано поле опису
- `views/movie/edit.php` - додано поле опису
- `views/movie/list.php` - додані кнопки навігації

### Нові файли:
- `controllers/ActivityController.php`
- `views/movie/gallery.php`
- `views/movie/detail.php`
- `views/movie/buy_ticket.php`
- `views/movie/create_screening.php`
- `views/activity/list.php`
- `views/activity/create.php`

---

## 💡 Можливості для розширення

- Додати зображення до фільмів (upload)
- Додати систему друзів
- Додати відгуки за рейтингом
- Додати фільтрацію по жанрах/рокам
- Додати сторінку історії куплених квитків
- Додати email-повідомлення про сеанси

---

**Автор**: LR5 V3 - Курсова робота  
**Дата**: 2026
