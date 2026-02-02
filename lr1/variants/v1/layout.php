<?php
// lr1/variants/v1/layout.php
// Глобальний шаблон для всіх завдань ЛР1 варіант 1

$lab = 'lr1';
$variant = 'v1';
$tasks = [
    'task2.php' => 'Завдання 2',
    'task3.php' => 'Завдання 3',
    'task4.php' => 'Завдання 4',
    'task5.php' => 'Завдання 5',
    'task6.php' => 'Завдання 6',
    'task7_table.php' => 'Завдання 7.1 (шахи)',
    'task7_squares.php' => 'Завдання 7.2 (кола)',
];
$labs = [
    'lr1' => 'ЛР1',
    // Додати інші лабораторні за потреби
];
$variants = [
    'v1' => 'Варіант 1',
    // Додати інші варіанти за потреби
];

$currentTask = basename($_SERVER['SCRIPT_NAME']);
$currentLab = $lab;
$currentVariant = $variant;

function renderLayout($content) {
    global $tasks, $labs, $variants, $currentTask, $currentLab, $currentVariant;
    ?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <title><?= $tasks[$currentTask] ?? 'Завдання' ?> — <?= $labs[$currentLab] ?? $currentLab ?>,
        <?= $variants[$currentVariant] ?? $currentVariant ?></title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="nav-center">
        <form class="nav" onsubmit="return false;">
            <button type="button" onclick="window.location.href='/'" class="nav-button">Головна</button>
            <button type="button" onclick="window.location.href='/lr1/demo/index.php'" class="nav-button">Демо</button>
            <label for="task-select">Завдання:</label>
            <select id="task-select" onchange="if(this.value)window.location.href=this.value;">
                <?php foreach ($tasks as $file => $name): ?>
                <option value="<?= $file ?>" <?= $file === $currentTask ? 'selected' : '' ?>><?= $name ?></option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>
    <div class="content-wrapper">
        <?= $content ?>
    </div>
</body>

</html>
<?php
}