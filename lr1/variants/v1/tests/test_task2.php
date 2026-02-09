<?php
/**
 * Тести для Завдання 2: Виведення форматованого тексту
 */

require_once __DIR__ . '/../tasks/task2.php';

$tests = [
    'generatePoem' => [
        [
            'name' => 'Вірш містить параграфи (<p>)',
            'input' => [],
            'validator' => function ($result) {
                return substr_count($result, '<p') >= 4;
            },
            'expected' => '4+ параграфів',
        ],
        [
            'name' => 'Слово "край" жирним',
            'input' => [],
            'validator' => function ($result) {
                return strpos($result, '<b>край</b>') !== false;
            },
            'expected' => '<b>край</b>',
        ],
        [
            'name' => 'Слово "золотим" курсивом',
            'input' => [],
            'validator' => function ($result) {
                return strpos($result, '<i>золотим</i>') !== false;
            },
            'expected' => '<i>золотим</i>',
        ],
        [
            'name' => 'Містить відступи (margin-left)',
            'input' => [],
            'validator' => function ($result) {
                return strpos($result, 'margin-left') !== false;
            },
            'expected' => 'margin-left стилі',
        ],
        [
            'name' => 'Містить текст "рідний дім"',
            'input' => [],
            'validator' => function ($result) {
                return strpos($result, 'рідний дім') !== false;
            },
            'expected' => 'Текст вірша',
        ],
        [
            'name' => 'Містить текст "серце"',
            'input' => [],
            'validator' => function ($result) {
                return strpos($result, 'серце') !== false;
            },
            'expected' => 'Текст вірша',
        ],
    ],
    // Helper функції hasBoldText, hasItalicText не тестуються
    // (вони вже реалізовані для використання в тестах)
];

return $tests;
