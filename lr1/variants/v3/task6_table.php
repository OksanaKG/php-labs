<?php
/**
 * Завдання 6.1: Таблиця 3x6  
 */

require_once __DIR__ . '/layout.php';

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

$content = '
    <h1>🎨 Таблиця ' . $rows . 'x' . $cols . '</h1>
    <div class="params">generateStripedTable(' . $rows . ', ' . $cols . ')</div>
    ' . $table;

renderVariantLayout($content, 'Завдання 6.1', 'task6-table-body');