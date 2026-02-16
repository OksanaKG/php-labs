# Лабораторна робота №3

**Тема:** ООП в PHP

## Теорія

[W3Schools — PHP OOP](https://www.w3schools.com/php/php_oop_what_is.asp) (класи, об'єкти, конструктори, клонування)

## Як виконувати

1. Подивіться робочий приклад: `demo/` — запустіть `php -S localhost:8000` і відкрийте `http://localhost:8000/lr3/demo/`
2. Створіть файли у папці `lr3/` (дивіться demo/ для прикладу структури)

**Де створювати файли:**

```text
lr3/
├── demo/           ← НЕ ЧІПАТИ (приклад від викладача)
├── index.php       ← ваш код
└── Users.php       ← ваш клас
```

**Як перевірити:** запустіть `php -S localhost:8000` і відкрийте `http://localhost:8000/lr3/index.php`

## Завдання

### 1. Створення класів та об'єктів

- Клас `Users` із властивостями: `name`, `login`, `password`
- Створити 3 об'єкти з довільними значеннями

### 2. Методи об'єкта

- Метод `getInfo()` — виводить значення властивостей
- Викликати для кожного об'єкта

### 3. Конструктор

- Конструктор задає початкові значення `name`, `login`, `password`
- Перестворити 3 об'єкти через конструктор

### 4. Клонування

- Метод `__clone()` — при копіюванні задає значення за замовчанням:
  - `name = "User"`, `login = "User"`, `password = "qwerty"`
- Створити 4-й об'єкт через `clone`

## Корисні посилання

- [PHP OOP](https://www.w3schools.com/php/php_oop_what_is.asp) — що таке ООП
- [PHP Classes/Objects](https://www.w3schools.com/php/php_oop_classes_objects.asp) — класи та об'єкти
- [PHP Constructor](https://www.w3schools.com/php/php_oop_constructor.asp) — конструктор
- [PHP Access Modifiers](https://www.w3schools.com/php/php_oop_access_modifiers.asp) — модифікатори доступу
- [PHP Object Cloning](https://www.php.net/manual/en/language.oop5.cloning.php) — клонування (php.net)

## Здача

- Гілка `lr3` в репозиторії (див. [acceptance-criteria.md](../docs/acceptance-criteria.md))
- Push на GitHub
