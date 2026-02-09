# Лабораторна робота №4-5

**Тема:** Створення MVC-додатку на PHP без використання фреймворків

## Теорія

W3Schools PHP OOP + лекція по MVC

## Завдання 1. Структура MVC

Створити скелет веб-додатку з MVC. Сторінки:
- Головна (статична)
- Форма реєстрації
- Форма відправки POST-запиту
- Сторінка перегляду GET та POST параметрів
- Єдина точка входу (`index.php`)

Тема сайту = тема курсової роботи.

## Завдання 2. Модулі

### Модуль обробки форми

- Мінімум 7 полів, 4 різних видів
- Варіанти валідації за номером (1-24):
  - ПІБ тільки англ. символами
  - Паролі збігаються + E-mail формат
  - Стать + вік = обмеження реєстрації
  - ПІБ не порожні + макс. 3 уподобання
  - Калькулятор (sum/sub/div/mul/pow/sqrt)
  - Логін одне слово + пароль/логін >= 4 символи

### Модуль сесій

- Вибір кольору фону → збереження в сесії → застосування на всіх сторінках

### Модуль Cookie

- Форма: ім'я + стать → cookie
- На всіх сторінках: `"Вітаємо Вас, пане/пані ІМ'Я"`

## Паттерн MVC — Класи

| Клас | Призначення |
|------|-------------|
| `Application` | Конструктор + `Run()` |
| `Router` | Обробка URL → контролер + action |
| `Request` | Обгортка `$_GET` / `$_POST` |
| `Controller` | Базовий клас |
| `PageController` | Реалізація для сторінок |
| `View` | Базовий клас view |
| `PageView` | Шаблон сторінки + блоки |

## Роутинг

Два підходи:
1. **Динамічні адреси**: `index.php?route=regform/doreg`
2. **Віртуальні адреси**: `/regform/doreg.html` через `.htaccess` RewriteRule

## Іменування

- Контролер `regform` → клас `RegformController` → файл `controllers/RegformController.php`
- Методи дій: `action_ІМ'ЯДІЇ()`
- View: `views/<контролер>/<шаблон>.php`

## Очікувана структура

```
/
├── classes/
│   ├── Application.php
│   ├── Controller.php
│   ├── PageController.php
│   ├── Request.php
│   ├── Route.php
│   ├── View.php
│   └── PageView.php
├── config/
│   └── init.php
├── controllers/
│   ├── IndexController.php
│   └── RegformController.php
├── views/
│   ├── layout/
│   │   ├── header.php
│   │   └── footer.php
│   ├── index/
│   │   └── main.php
│   ├── regform/
│   │   ├── form.php
│   │   └── done.php
│   └── reqview/
│       └── showrequest.php
├── index.php
└── .htaccess
```

## Здача

Закомітити на git.ztu.edu.ua, доступ викладачам.
