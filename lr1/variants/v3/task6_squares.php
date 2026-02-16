<?php
/**
 * Завдання 6.2: 5 червоних квадратів на чорному тлі
 */

require_once dirname(__DIR__, 3) . '/shared/helpers/dev_reload.php';

function generateRandomSquares(int $n): string
{
    $html = "<div style='position:relative;width:100vw;height:100vh;background:#000000;overflow:hidden;'>";

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
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Завдання 6.2 — Червоні квадрати</title>
    <link rel="stylesheet" href="../../demo/demo.css">
</head>
<body class="task6-squares-body">
    <header class="header-fixed">
        <div class="header-left">
            <a href="/" class="header-btn">Головна</a>
            <a href="index.php" class="header-btn">← Варіант 3</a>
            <a href="/lr1/demo/task6_squares.php?from=v3" class="header-btn header-btn-demo">Demo</a>
        </div>
        <div class="header-center"></div>
        <div class="header-right">В-3 / Завд. 6.2</div>
    </header>

    <?= $squares ?>

    <div class="circles-func">generateRandomSquares(<?= $n ?>)</div>
    <div class="circles-counter">🟥 Квадратів: <?= $n ?></div>
    <p class="circles-info">Оновіть сторінку для нової композиції 🔄</p>

    <?= devReloadScript() ?>
</body>
</html>