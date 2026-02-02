<?php
/**
 * Завдання 7: Робота з циклами
 */

/**
 * Завдання 7.1: Генерує HTML шахової дошки n×n
 *
 * Дошка має чергувати білі (#fff) та чорні (#000) клітинки.
 * Перша клітинка (0,0) — біла.
 *
 * @param int $n Розмір дошки (кількість рядків = кількість стовпців)
 * @return string HTML-код таблиці
 */
function generateChessboard(int $n): string
{
    $html = "<table border='1' cellspacing='0'>";
    for ($i = 0; $i < $n; $i++) {
        $html .= "<tr>";
        for ($j = 0; $j < $n; $j++) {
            $color = (($i + $j) % 2 === 0) ? "#fff" : "#000";
            $html .= "<td style='width:50px; height:50px; background:$color;'></td>";
        }
        $html .= "</tr>";
    }
    $html .= "</table>";
    return $html;
}

/**
 * Завдання 7.2: Генерує HTML з випадковими колами
 *
 * Створює n жовтих кіл на синьому тлі (#0066cc).
 * Кожне коло має випадковий розмір (20-80px) та позицію (5-85%).
 *
 * @param int $n Кількість кіл
 * @return string HTML-код з колами
 */
function generateRandomCircles(int $n): string
{
    $html = "<div style='position:relative; width:100vw; height:100vh; background:#0066cc;'>";
    for ($i = 0; $i < $n; $i++) {
        $size = mt_rand(20, 80);
        $top = mt_rand(5, 85);
        $left = mt_rand(5, 85);
        $html .= "<div style='position:absolute; width:{$size}px; height:{$size}px; background:yellow; border-radius:50%; top:{$top}%; left:{$left}%;'></div>";
    }
    $html .= "</div>";
    return $html;
}
