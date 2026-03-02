<?php
/**
 * Завдання 6.2: 5 червоних квадратів на чорному тлі
 */

require_once __DIR__ . '/layout.php';

function generateRandomSquares(int $n): string
{
    $html = "<div class='shapes-container shapes-container--black'>";

    for ($i = 0; $i < $n; $i++) {
        $size = mt_rand(20, 80);
        $top = mt_rand(5, 85);
        $left = mt_rand(5, 85);

        $html .= "<div style='
            position:absolute;
            top:{$top}%;
            left:{$left}%;
            width:{$size}px;
            height:{$size}px;
            background:#ef4444;
            border: 1px solid #ffffff;
        '></div>";
    }

    $html .= "</div>";
    return $html;
}

$n = 5;
$squares = generateRandomSquares($n);

$content = $squares . '
    <div class="circles-func">generateRandomSquares(' . $n . ')</div>
    <div class="circles-counter">🟥 Квадратів: ' . $n . '</div>
    <p class="circles-info">Оновіть сторінку для нової композиції 🔄</p>';

renderVariantLayout($content, 'Завдання 6.2', 'task6-squares-body');