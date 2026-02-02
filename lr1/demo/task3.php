<?php
/**
 * Завдання 3: Конвертер валют (EUR → UAH)
 * Варіант 1
 *
 * Демонстрація: змінні, арифметичні операції, функції
 */

/**
 * Конвертує євро в гривні
 */
function convertEurToUah(float $eur, float $rate): int
{
    return (int) floor($eur * $rate);
}

/**
 * Форматує результат конвертації
 */
function formatConversionResult(float $eur, int $uah): string
{
    return "{$eur} євро = {$uah} грн";
}

// Вхідні дані (v1)
$eur = 250;
$rate = 45.20;

// Розрахунок
$uah = convertEurToUah($eur, $rate);
$result = formatConversionResult($eur, $uah);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Завдання 3 — Конвертер валют (v1)</title>
    <link rel="stylesheet" href="demo.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <div class="back-button-container">
        <button onclick="window.location.href='index.php'" class="back-button">← До демо</button>
    </div>
    <div class="card">
        <h2>💶 Конвертер EUR → UAH</h2>
        <p><strong>Курс:</strong> 1 EUR = <?= $rate ?> грн</p>
        <div class="result">
            <?= $result ?>
        </div>
        <p class="info">Функція: convertEurToUah(<?= $eur ?>, <?= $rate ?>) = <?= $uah ?></p>
    </div>
</body>
</html>
