<?php
/**
 * Завдання 6.1: Таблиця 3x6  
 */

require_once dirname(__DIR__, 3) . '/shared/helpers/dev_reload.php';
require_once dirname(__DIR__, 3) . '/shared/helpers/paths.php';

function generateStripedTable(int $rows, int $cols, string $color1, string $color2): string
{
    $html = "<table class='chessboard'>";
    for ($i = 0; $i < $rows; $i++) {
        $bgColor = ($i % 2 === 0) ? $color1 : $color2;
        $html .= "<tr>";
        for ($j = 0; $j < $cols; $j++) {
            $html .= "<td style='background-color:{$bgColor};'></td>";
        }
        $html .= "</tr>";
    }
    $html .= "</table>";
    return $html;
}

$rows = 3;
$cols = 6;
$color1 = '#ec4899';
$color2 = '#f472b6';

$table = generateStripedTable($rows, $cols, $color1, $color2);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Завдання 6.1 — Таблиця</title>
    <link rel="stylesheet" href="<?= webPath(dirname(__DIR__, 3) . '/shared/css/base.css') ?>">
    <link rel="stylesheet" href="<?= webPath(dirname(__DIR__, 2) . '/demo/demo.css') ?>">
</head>
<body class="task6-table-body body-with-header">
    <header class="header-fixed">
        <div class="header-left">
            <a href="/" class="header-btn">Головна</a>
            <a href="index.php" class="header-btn">← Варіант 3</a>
            <a href="/lr1/demo/task6_table.php?from=v3" class="header-btn header-btn-demo">Demo</a>
        </div>
        <div class="header-center"></div>
        <div class="header-right">В-3 / Завд. 6.1</div>
    </header>

    <h1>🎨 Таблиця <?= $rows ?>x<?= $cols ?></h1>
    <div class="params">generateStripedTable(<?= $rows ?>, <?= $cols ?>)</div>

    <?= $table ?>

    <?= devReloadScript() ?>
</body>
</html>