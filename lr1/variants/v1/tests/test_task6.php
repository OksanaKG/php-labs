<?php
/**
 * Тести для Завдання 6: Операції з чотиризначним числом
 */

require_once __DIR__ . '/../tasks/task6.php';

$tests = [
    'sumOfDigits' => [
        [
            'name' => 'Сума цифр 1234 = 10',
            'input' => [1234],
            'expected' => 10,
        ],
        [
            'name' => 'Сума цифр 1000 = 1',
            'input' => [1000],
            'expected' => 1,
        ],
        [
            'name' => 'Сума цифр 9999 = 36',
            'input' => [9999],
            'expected' => 36,
        ],
        [
            'name' => 'Сума цифр 5678 = 26',
            'input' => [5678],
            'expected' => 26,
        ],
    ],
    'productOfDigits' => [
        [
            'name' => 'Добуток цифр 1234 = 24',
            'input' => [1234],
            'expected' => 24,
        ],
        // Не тестуємо 1000 (результат 0 співпадає зі stub)
        [
            'name' => 'Добуток цифр 2222 = 16',
            'input' => [2222],
            'expected' => 16,
        ],
        [
            'name' => 'Добуток цифр 1111 = 1',
            'input' => [1111],
            'expected' => 1,
        ],
        [
            'name' => 'Добуток цифр 2345 = 120',
            'input' => [2345],
            'expected' => 120,
        ],
    ],
    'reverseNumber' => [
        [
            'name' => 'Реверс 1234 = 4321',
            'input' => [1234],
            'expected' => 4321,
        ],
        [
            'name' => 'Реверс 1000 = 1 (або 0001)',
            'input' => [1000],
            'expected' => 1,
        ],
        [
            'name' => 'Реверс 9999 = 9999',
            'input' => [9999],
            'expected' => 9999,
        ],
        [
            'name' => 'Реверс 1230 = 321 (або 0321)',
            'input' => [1230],
            'expected' => 321,
        ],
    ],
    'maxFromDigits' => [
        [
            'name' => 'Макс з 1234 = 4321',
            'input' => [1234],
            'expected' => 4321,
        ],
        [
            'name' => 'Макс з 3021 = 3210',
            'input' => [3021],
            'expected' => 3210,
        ],
        [
            'name' => 'Макс з 9876 = 9876',
            'input' => [9876],
            'expected' => 9876,
        ],
        [
            'name' => 'Макс з 1111 = 1111',
            'input' => [1111],
            'expected' => 1111,
        ],
    ],
];

return $tests;
