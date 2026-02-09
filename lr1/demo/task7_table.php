<?php
/**
 * Завдання 7.1: Кольорова таблиця n×n
 *
 * Демонстрація: цикли for, функції, генерація HTML/CSS
 */

/**
 * Генерує HTML таблицю n×n з випадковими кольорами
 */
function generateColorTable(int $n): string
{
    $html = "<table class='chessboard'>";
    for ($i = 0; $i < $n; $i++) {
        $html .= "<tr>";
        for ($j = 0; $j < $n; $j++) {
            $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            $html .= "<td style='background-color:$color;'></td>";
        }
        $html .= "</tr>";
    }
    $html .= "</table>";
    return $html;
}

// Check if came from variant
$fromVariant = $_GET['from'] ?? null;
$variantUrl = null;
if ($fromVariant && preg_match('/^v\d+$/', $fromVariant)) {
    $variantUrl = "/lr1/variants/{$fromVariant}/task7_table.php";
}
$fromParam = $fromVariant ? '?from=' . htmlspecialchars($fromVariant) : '';

// Параметри (demo)
$n = 5;

// Генеруємо таблицю
$table = generateColorTable($n);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Завдання 7.1 — Кольорова таблиця</title>
    <link rel="stylesheet" href="demo.css">
</head>
<body class="task7-table-body body-with-header">
    <header class="header-fixed">
        <div class="header-left">
            <a href="/" class="header-btn">Головна</a>
            <a href="index.php<?= $fromParam ?>" class="header-btn">← Демо</a>
            <?php if ($variantUrl): ?>
            <a href="<?= htmlspecialchars($variantUrl) ?>" class="header-btn header-btn-variant">← Варіант <?= htmlspecialchars(substr($fromVariant, 1)) ?></a>
            <?php endif; ?>
        </div>
        <div class="header-center"></div>
        <div class="header-right">Демо / Завд. 7.1</div>
    </header>

    <h1>🎨 Кольорова таблиця <?= $n ?>×<?= $n ?></h1>
    <div class="params">generateColorTable(<?= $n ?>)</div>

    <?= $table ?>

    <p class="info" style="color:rgba(255,255,255,0.8);margin-top:20px;">Оновіть сторінку для нових кольорів 🔄</p>
</body>
</html>
