<?php
/**
 * Завдання 6: Операції з чотиризначним числом
 * Варіант 1
 *
 * Демонстрація: mt_rand(), арифметичні операції, масиви, сортування
 */

/**
 * Обчислює суму цифр числа
 */
function sumOfDigits(int $number): int
{
    $sum = 0;
    while ($number > 0) {
        $sum += $number % 10;
        $number = (int)($number / 10);
    }
    return $sum;
}

/**
 * Обчислює добуток цифр числа
 */
function productOfDigits(int $number): int
{
    $product = 1;
    while ($number > 0) {
        $product *= $number % 10;
        $number = (int)($number / 10);
    }
    return $product;
}

/**
 * Повертає число в зворотному порядку
 */
function reverseNumber(int $number): int
{
    $reversed = 0;
    while ($number > 0) {
        $reversed = $reversed * 10 + $number % 10;
        $number = (int)($number / 10);
    }
    return $reversed;
}

/**
 * Повертає найбільше можливе число з цифр
 */
function maxFromDigits(int $number): int
{
    $digits = str_split((string)$number);
    rsort($digits);
    return (int)implode('', $digits);
}

// Вхідні дані (v1) — чотиризначне число
$number = mt_rand(1000, 9999);

// Розбиваємо число на цифри для відображення
$d1 = (int)($number / 1000);
$d2 = (int)(($number % 1000) / 100);
$d3 = (int)(($number % 100) / 10);
$d4 = $number % 10;

// Обчислення
$sum = sumOfDigits($number);
$product = productOfDigits($number);
$reversed = reverseNumber($number);
$maxNum = maxFromDigits($number);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Завдання 6 — Чотиризначне число (v1)</title>
    <link rel="stylesheet" href="demo.css">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            padding: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .container { max-width: 500px; margin: 0 auto; }
        .card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
            margin-bottom: 20px;
            max-width: none;
        }
        .number {
            font-size: 64px;
            font-weight: bold;
            text-align: center;
            color: #4f46e5;
            letter-spacing: 8px;
        }
        .digits {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }
        .digit {
            width: 50px;
            height: 50px;
            background: #e0e7ff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            color: #4338ca;
        }
        .result {
            padding: 15px;
            background: #f8fafc;
            border-radius: 8px;
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .result-value {
            font-size: 20px;
            font-weight: bold;
            color: #059669;
        }
        h3 { margin: 0 0 15px 0; color: #1e293b; }
        .func { font-family: monospace; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="back-button-container">
        <button onclick="window.location.href='index.php'" class="back-button">← До демо</button>
    </div>
    <div class="container">
        <div class="card">
            <h3>🎲 Випадкове чотиризначне число</h3>
            <div class="number"><?= $number ?></div>
            <div class="digits">
                <div class="digit"><?= $d1 ?></div>
                <div class="digit"><?= $d2 ?></div>
                <div class="digit"><?= $d3 ?></div>
                <div class="digit"><?= $d4 ?></div>
            </div>
        </div>

        <div class="card">
            <h3>📊 Результати</h3>

            <div class="result">
                <div>
                    <span>1. Сума цифр</span>
                    <div class="func">sumOfDigits(<?= $number ?>)</div>
                </div>
                <span class="result-value"><?= $sum ?></span>
            </div>

            <div class="result">
                <div>
                    <span>2. Добуток цифр</span>
                    <div class="func">productOfDigits(<?= $number ?>)</div>
                </div>
                <span class="result-value"><?= $product ?></span>
            </div>

            <div class="result">
                <div>
                    <span>3. В зворотному порядку</span>
                    <div class="func">reverseNumber(<?= $number ?>)</div>
                </div>
                <span class="result-value"><?= $reversed ?></span>
            </div>

            <div class="result">
                <div>
                    <span>4. Найбільше можливе</span>
                    <div class="func">maxFromDigits(<?= $number ?>)</div>
                </div>
                <span class="result-value"><?= $maxNum ?></span>
            </div>
        </div>

        <p style="text-align: center; color: white; opacity: 0.8;">
            Оновіть сторінку для нового числа 🔄
        </p>
    </div>
</body>
</html>
