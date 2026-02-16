<?php
/**
 * Variant 3 Index Page
 */


require_once dirname(__DIR__, 3) . '/shared/templates/task_cards.php';

$tasks = [
    'task1.php' => ['name' => 'Завдання 1: Текст'],
    'task2.php' => ['name' => 'Завдання 2: Валюта'],
    'task3.php' => ['name' => 'Завдання 3: Сезон'],
    'task4.php' => ['name' => 'Завдання 4: Символ'],
    'task5.php' => ['name' => 'Завдання 5: Число'],
    'task6_table.php' => ['name' => 'Завдання 6.1: Таблиця'],
    'task6_squares.php' => ['name' => 'Завдання 6.2: Квадрати'],
];


$demoUrl = '/lr1/demo/index.php?from=v3';
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Варіант 3 — ЛР1</title>
    <link rel="stylesheet" href="../../demo/demo.css">
</head>
<body class="index-page">
    <header class="header-fixed">
        <div class="header-left">
            <a href="/" class="header-btn">Головна</a>
        </div>
        <div class="header-center"></div>
        <div class="header-right">
            Варіант 3
        </div>
    </header>

    <h1 class="index-title">
        Варіант 3
        <br><span class="index-subtitle">Лабораторна робота №1</span>
    </h1>

    <?= renderTaskCards($tasks, true, $demoUrl) ?>
</body>
</html>