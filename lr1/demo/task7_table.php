<?php
/**
 * Завдання 7.1: Шахова дошка n×n
 * Варіант 1
 *
 * Демонстрація: цикли for, функції, генерація HTML/CSS
 */

/**
 * Генерує HTML шахової дошки n×n
 *
 * @param int $n Розмір дошки
 * @return string HTML-код таблиці
 */
function generateChessboard(int $n): string
{
    $html = "<table class='chessboard'>";
    for ($i = 0; $i < $n; $i++) {
        $html .= "<tr>";
        for ($j = 0; $j < $n; $j++) {
            // Чергування кольорів: якщо сума індексів парна — біла, інакше чорна
            $isWhite = ($i + $j) % 2 === 0;
            $color = $isWhite ? '#fff' : '#000';
            $html .= "<td style='background-color: $color;'></td>";
        }
        $html .= "</tr>";
    }
    $html .= "</table>";
    return $html;
}

// Параметри (v1)
$n = 8;

// Генеруємо дошку
$chessboard = generateChessboard($n);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Завдання 7.1 — Шахова дошка (v1)</title>
    <link rel="stylesheet" href="demo.css">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: linear-gradient(135deg, #5d4e37 0%, #8b7355 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h1 { color: white; margin-bottom: 30px; }
        .chessboard {
            border-collapse: collapse;
            box-shadow: 0 8px 32px rgba(0,0,0,0.4);
            border: 4px solid #5d4037;
        }
        .chessboard td {
            width: 60px;
            height: 60px;
            border: 1px solid #5d4037;
        }
        .params {
            color: white;
            background: rgba(255,255,255,0.1);
            padding: 10px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="back-button-container">
        <button onclick="window.location.href='index.php'" class="back-button">← До демо</button>
    </div>
    <h1>♟️ Шахова дошка <?= $n ?>×<?= $n ?></h1>
    <div class="params">
        generateChessboard(<?= $n ?>)
    </div>

    <?= $chessboard ?>

    <p class="info" style="color:rgba(255,255,255,0.8);margin-top:20px;">Біла клітинка (0,0) → чергування білих (#fff) та чорних (#000) клітинок</p>
</body>
</html>
