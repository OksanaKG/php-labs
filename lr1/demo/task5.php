<?php
/**
 * Завдання 5: Парне/Непарне число (switch)
 * Варіант 1
 *
 * Демонстрація: конструкція switch
 */

/**
 * Визначає чи є цифра парною чи непарною
 *
 * @param int $digit Цифра (0-9)
 * @return string "парна" або "непарна"
 */
function isEvenOrOdd(int $digit): string
{
    switch ($digit) {
        case 0:
        case 2:
        case 4:
        case 6:
        case 8:
            return "парна";
        case 1:
        case 3:
        case 5:
        case 7:
        case 9:
            return "непарна";
        default:
            return "невідомо";
    }
}

// Вхідні дані (v1)
$digit = 7;

// Визначення
$result = isEvenOrOdd($digit);
$isEven = $result === "парна";

$color = $isEven ? "#10b981" : "#ef4444";
$emoji = $isEven ? "✓" : "✗";
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Завдання 5 — Парне/Непарне (v1)</title>
    <link rel="stylesheet" href="demo.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 8px 40px rgba(0,0,0,0.3);
            text-align: center;
            max-width: none;
        }
        .digit {
            font-size: 120px;
            font-weight: bold;
            color: <?= $color ?>;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        .result {
            font-size: 28px;
            margin-top: 20px;
            color: #374151;
            background: none;
            padding: 0;
        }
        .emoji { font-size: 48px; color: <?= $color ?>; }
    </style>
</head>
<body>
    <div class="back-button-container" style="position:fixed;top:20px;left:20px;">
        <button onclick="window.location.href='index.php'" class="back-button">← До демо</button>
    </div>
    <div class="card">
        <div class="digit"><?= $digit ?></div>
        <div class="emoji"><?= $emoji ?></div>
        <div class="result">
            Цифра <strong><?= $digit ?></strong> — <span style="color: <?= $color ?>"><?= $result ?></span>
        </div>
        <p class="info">Функція: isEvenOrOdd(<?= $digit ?>) = "<?= $result ?>"</p>
    </div>
</body>
</html>
