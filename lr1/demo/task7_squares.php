<?php
/**
 * Завдання 7.2: Випадкові жовті кола на синьому тлі
 * Варіант 1
 *
 * Демонстрація: цикли, функції, CSS positioning, mt_rand()
 */

/**
 * Генерує HTML з випадковими колами
 *
 * @param int $n Кількість кіл
 * @return string HTML-код з колами
 */
function generateRandomCircles(int $n): string
{
    $html = "<div class='container' style='position:relative; width:100vw; height:100vh; background:#0066cc;'>";

    for ($i = 0; $i < $n; $i++) {
        $size = mt_rand(20, 80);      // Випадковий розмір 20-80px
        $top = mt_rand(5, 85);        // Випадкова позиція зверху (%)
        $left = mt_rand(5, 85);       // Випадкова позиція зліва (%)
        $opacity = mt_rand(70, 100) / 100;

        $html .= "<div class='circle' style='
            position: absolute;
            width: {$size}px;
            height: {$size}px;
            top: {$top}%;
            left: {$left}%;
            background: yellow;
            border-radius: 50%;
            opacity: {$opacity};
        '></div>";
    }

    $html .= "</div>";
    return $html;
}

// Кількість кіл (v1)
$n = 12;

// Генеруємо
$circles = generateRandomCircles($n);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Завдання 7.2 — Жовті кола (v1)</title>
    <link rel="stylesheet" href="demo.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            min-height: 100vh;
            overflow: hidden;
        }
        .circle {
            box-shadow: 0 4px 20px rgba(255, 255, 0, 0.4);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .circle:hover {
            transform: scale(1.3);
            box-shadow: 0 8px 40px rgba(255, 255, 0, 0.8);
            z-index: 100;
        }
        .func {
            position: fixed;
            top: 20px;
            left: 20px;
            color: white;
            font-family: monospace;
            font-size: 14px;
            background: rgba(0,0,0,0.3);
            padding: 10px 15px;
            border-radius: 8px;
        }
        .counter {
            position: fixed;
            top: 20px;
            right: 20px;
            color: white;
            font-family: Arial, sans-serif;
            font-size: 18px;
            background: rgba(0,0,0,0.3);
            padding: 10px 20px;
            border-radius: 8px;
        }
        .info {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255,255,255,0.7);
            font-family: Arial, sans-serif;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="back-button-container" style="position:fixed;top:60px;left:20px;z-index:1000;">
        <button onclick="window.location.href='index.php'" class="back-button">← До демо</button>
    </div>
    <?= $circles ?>

    <div class="func">generateRandomCircles(<?= $n ?>)</div>
    <div class="counter">🟡 Кіл: <?= $n ?></div>
    <p class="info">Наведіть курсор на коло для анімації. Оновіть сторінку для нової композиції.</p>
</body>
</html>
