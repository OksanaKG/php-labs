# Лабораторна робота №1

**Тема:** Базові конструкції мови PHP

## Теорія

- Змінні, типи даних, операції в PHP
- Конструкція if..else, switch, цикли
- Джерело: [W3Schools PHP Tutorial](https://www.w3schools.com/php/)

## Як виконувати

1. Прочитайте свій варіант: `variants/vN.md` (де N — ваш номер)
2. Подивіться робочий приклад: `demo/` — запустіть `php -S localhost:8000` і відкрийте `http://localhost:8000/lr1/demo/`
3. Подивіться повністю розв'язаний варіант 30: `variants/v30/` — `http://localhost:8000/lr1/variants/v30/`

**Де створювати файли:**

1. Скопіюйте папку `variants/v30/` → перейменуйте в `variants/vN/` (де N — ваш номер)
2. Замініть дані з `v30.md` на дані з вашого `vN.md`

```text
lr1/
├── demo/               ← НЕ ЧІПАТИ (приклад від викладача)
├── variants/
│   ├── v1.md ... v30.md  ← завдання (НЕ ЧІПАТИ)
│   ├── v30/            ← reference implementation (НЕ ЧІПАТИ)
│   └── vN/             ← ← ← ВАША ПАПКА
│       ├── index.php       ← завдання 1: перша програма
│       ├── task2.php       ← завдання 2: конвертер
│       ├── task3.php       ← завдання 3: сезон
│       └── ...
└── assignment.md
```

> Нумерація файлів відповідає номерам завдань нижче. Завдання 0 — налаштування, завдання 1 — `index.php`, завдання 2 — `task2.php`, і так далі.

**Як перевірити:** запустіть `php -S localhost:8000` з кореня проєкту і відкрийте `http://localhost:8000/lr1/variants/vN/`

## Передумови

Встановити PHP та Git — див. [setup/README.md](../setup/README.md). Запуск: `php -S localhost:8000` з кореня проєкту.

## Завдання

### 1. Перша програма

Створити `index.php`, який виводить форматований текст (вірш з відступами та жирним шрифтом).

### 2. Конвертер валют

- Вхід: сума в гривнях (задається програмно)
- Вихід: `"1500 грн. можна обміняти на 51 долар"`

### 3. Визначення сезону

- Вхід: номер місяця (1-12, програмно)
- Вихід: відповідний сезон пори року
- Вимога: використати `if-else`

### 4. Голосний чи приголосний

- Вхід: символ (програмно)
- Вихід: голосний / приголосний
- Вимога: використати `switch`

### 5. Тризначне число

- Вхід: випадкове тризначне число (`mt_rand()`)
- Задачі:
  1. Сума цифр
  2. Число у зворотному порядку
  3. Переставити цифри для найбільшого можливого числа

### 6. Робота з циклами (2 підзавдання)

1. Функція `(rows, cols)` → HTML-таблиця n x n комірок різного кольору
2. Функція `(n)` → n червоних квадратів випадкового розміру в випадковій позиції на чорному тлі

## Корисні посилання

- [PHP echo/print](https://www.w3schools.com/php/php_echo_print.asp) — вивід тексту
- [PHP Variables](https://www.w3schools.com/php/php_variables.asp) — змінні
- [PHP Operators](https://www.w3schools.com/php/php_operators.asp) — оператори
- [PHP If...Else](https://www.w3schools.com/php/php_if_else.asp) — умови
- [PHP Switch](https://www.w3schools.com/php/php_switch.asp) — switch
- [PHP Loops](https://www.w3schools.com/php/php_looping_for.asp) — цикли
- [PHP Arrays](https://www.w3schools.com/php/php_arrays.asp) — масиви
- [PHP Functions](https://www.w3schools.com/php/php_functions.asp) — функції
- [PHP Math](https://www.w3schools.com/php/php_math.asp) — математичні функції
- [HTML Formatting](https://www.w3schools.com/html/html_formatting.asp) — форматування тексту

## Здача

- Гілка `lr1` в репозиторії (див. [acceptance-criteria.md](../docs/acceptance-criteria.md))
- Push на GitHub
