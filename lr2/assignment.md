# Лабораторна робота №2

**Тема:** Використання функцій, рядків, масивів та форм в PHP

## Теорія

[W3Schools PHP Tutorial](https://www.w3schools.com/php/) — функції, рядки, масиви, форми

## Як виконувати

1. Прочитайте свій варіант: `variants/vN.md` (де N — ваш номер)
2. Подивіться робочий приклад: `demo/` — запустіть `php -S localhost:8000` і відкрийте `http://localhost:8000/lr2/demo/`

**Де створювати файли:**

```text
lr2/
├── demo/           ← НЕ ЧІПАТИ (приклад від викладача)
├── variants/       ← НЕ ЧІПАТИ (завдання)
├── task1_replace.php   ← ваш код
├── task2_sort.php      ← ваш код
└── ...
```

> Називайте файли так само, як у `demo/`. Структуру файлів беріть з прикладу.

**Як перевірити:** запустіть `php -S localhost:8000` з кореня проєкту і відкрийте ваш файл у браузері.

## Завдання

### 1. Робота з рядками (5 завдань)

1. **Знайти і замінити** — 4 текстових поля (Текст, Знайти, Замінити, Результат), заміна символів
2. **Сортування міст** — введення через пробіл → алфавітний порядок
3. **Ім'я файлу** — з повного шляху `D:\...\myfile.txt` виділити ім'я без розширення
4. **Різниця дат** — два рядки формату `ДД-ММ-РРРР` → кількість днів між ними
5. **Генератор + перевірка паролів**:
   - Генерація випадкового пароля заданої довжини (великі/малі літери, цифри, спецсимволи)
   - Перевірка міцності: >= 1 велика, >= 1 мала, >= 1 цифра, >= 1 спецсимвол, довжина >= 8

### 2. Робота з масивами (4 завдання)

1. **Дублікати** — функція приймає масив → вивести елементи, що повторюються
2. **Генератор імен тварин** — функція приймає масив складів → генерує ім'я
3. **Операції з масивами**:
   - `createArray()` — масив випадкової довжини (3-7) з випадковими значеннями (10-20)
   - Функція: з'єднати 2 масиви → видалити дублікати → сортувати за зростанням
4. **Асоціативний масив** — ключі: імена, значення: вік. Сортування за параметром (за віком або за іменем)

### 3. Робота з формою (1 завдання)

1. `.htaccess` з `AddDefaultCharset utf-8`
2. `index.php` з формою: логін, пароль (2x), стать (radio), місто (select), хобі (checkbox), про себе (textarea), фотографія (file)
3. Друга сторінка: прийом і відображення даних (вкл. фото)
4. Збереження в сесію, автозаповнення форми при поверненні
5. Вибір мови (іконки) → GET-параметр → cookie (півроку) → відображення `"Вибрана мова: Українська"`

### 4. Робота з функціями (1 завдання)

1. Папка `Function/func.php` — функції: sin, cos, tg, my_tg(x), x^y, x!
2. `index.php` — форма з полями x, y
3. `calculate.php` — обробка, виклик функцій, таблиця результатів

## Корисні посилання

- [PHP String Functions](https://www.w3schools.com/php/php_ref_string.asp) — рядкові функції
- [PHP str_replace()](https://www.w3schools.com/php/func_string_str_replace.asp) — пошук та заміна
- [PHP Array Functions](https://www.w3schools.com/php/php_ref_array.asp) — функції масивів
- [PHP Array Sorting](https://www.w3schools.com/php/php_arrays_sort.asp) — сортування масивів
- [PHP Date/Time](https://www.w3schools.com/php/php_date.asp) — дата і час
- [PHP Forms](https://www.w3schools.com/php/php_forms.asp) — форми
- [PHP Form Handling](https://www.w3schools.com/php/php_form_handling.asp) — обробка форм
- [PHP Sessions](https://www.w3schools.com/php/php_sessions.asp) — сесії
- [PHP Cookies](https://www.w3schools.com/php/php_cookies.asp) — cookies
- [PHP File Upload](https://www.w3schools.com/php/php_file_upload.asp) — завантаження файлів
- [PHP Math](https://www.w3schools.com/php/php_math.asp) — математичні функції
- [PHP Functions](https://www.w3schools.com/php/php_functions.asp) — користувацькі функції

## Здача

- Гілка `lr2` в репозиторії (див. [acceptance-criteria.md](../docs/acceptance-criteria.md))
- Push на GitHub
