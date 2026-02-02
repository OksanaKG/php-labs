<?php
/**
 * Завдання 2: Виведення форматованого тексту
 *
 * Демонстрація: echo, HTML-теги, стилі
 */
?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <title>Завдання 2 — Вірш</title>
    <link rel="stylesheet" href="demo.css">
    <style>
    body {
        font-family: Georgia, serif;
        font-size: 18px;
        line-height: 1.8;
        padding: 40px;
        background: #f5f5f5;
    }

    .poem {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 500px;
    }
    </style>
</head>

<body>
    <div class="back-button-container">
        <button onclick="window.location.href='index.php'" class="back-button">← До демо</button>
    </div>
    <div class="poem">
        <?php
        echo "<p>Полину в мріях в купель океану,</p>";
        echo "<p>Відчую <b>шовковистість</b> глибини,</p>";
        echo "<p>Чарівні мушлі з дна собі дістану,</p>";
        echo "<p style='margin-left: 20px;'>Щоб <i>взимку</i></p>";
        echo "<p style='margin-left: 40px;'>тішили</p>";
        echo "<p style='margin-left: 60px;'>мене</p>";
        echo "<p style='margin-left: 80px;'>вони…</p>";
        ?>
    </div>
</body>

</html>
