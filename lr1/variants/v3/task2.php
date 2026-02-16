<?php
/**
 * Завдання 2: Конвертер валют (UAH → USD)
 *
 * 25000 грн → доларів, курс 42.10
 */
require_once __DIR__ . '/layout.php';

function convertUahToUsd(float $uah, float $rate): float
{
    return round($uah / $rate, 2);
}

// Вхідні дані (варіант 3)
$uah = 25000;
$rate = 42.10;

$usd = convertUahToUsd($uah, $rate);

$content = '<div class="card">
    <h2>💵 Конвертер UAH → USD</h2>
    <p><strong>Курс:</strong> 1 USD = ' . $rate . ' грн</p>
    <div class="result">' . $uah . ' грн = ' . $usd . ' доларів</div>
    <p class="info">convertUahToUsd(' . $uah . ', ' . $rate . ') = ' . $usd . '</p>
</div>';

renderVariantLayout($content, 'Завдання 2', 'task2-body');