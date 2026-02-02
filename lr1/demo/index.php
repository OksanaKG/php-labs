<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <title>ЛР1 — Демо завдання</title>
    <style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%);
        min-height: 100vh;
        margin: 0;
        padding: 40px;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
    }

    h1 {
        color: white;
        text-align: center;
        margin-bottom: 40px;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        text-decoration: none;
        color: #1e293b;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
    }

    .card-icon {
        font-size: 48px;
        margin-bottom: 12px;
    }

    .card-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .card-desc {
        font-size: 14px;
        color: #64748b;
    }

    .back-link {
        display: block;
        text-align: center;
        color: rgba(255, 255, 255, 0.7);
        margin-top: 30px;
        text-decoration: none;
    }

    .back-link:hover {
        color: white;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>🎓 Лабораторна робота №1<br><small style="font-weight: normal; font-size: 0.5em;">Базові конструкції мови
                PHP</small></h1>

        <div class="grid">
            <a href="task2.php" class="card">
                <div class="card-icon">📝</div>
                <div class="card-title">Завдання 2</div>
                <div class="card-desc">Виведення форматованого тексту (вірш)</div>
            </a>

            <a href="task3.php" class="card">
                <div class="card-icon">💱</div>
                <div class="card-title">Завдання 3</div>
                <div class="card-desc">Конвертер гривень в долари</div>
            </a>

            <a href="task4.php" class="card">
                <div class="card-icon">🌤️</div>
                <div class="card-title">Завдання 4</div>
                <div class="card-desc">Сезон за номером місяця (if-else)</div>
            </a>

            <a href="task5.php" class="card">
                <div class="card-icon">🔤</div>
                <div class="card-title">Завдання 5</div>
                <div class="card-desc">Голосна чи приголосна (switch)</div>
            </a>

            <a href="task6.php" class="card">
                <div class="card-icon">🔢</div>
                <div class="card-title">Завдання 6</div>
                <div class="card-desc">Операції з тризначним числом</div>
            </a>

            <a href="task7_table.php" class="card">
                <div class="card-icon">🎨</div>
                <div class="card-title">Завдання 7.1</div>
                <div class="card-desc">Кольорова таблиця n×n</div>
            </a>

            <a href="task7_squares.php" class="card">
                <div class="card-icon">🟥</div>
                <div class="card-title">Завдання 7.2</div>
                <div class="card-desc">Випадкові червоні квадрати</div>
            </a>
        </div>

        <a href="/" class="back-link">← На головну</a>
    </div>
</body>

</html>