<?php
/**
 * Завдання 4: Визначення пори доби (if-else)
 * Варіант 1
 *
 * Демонстрація: конструкція if-else
 */

/**
 * Визначає пору доби за годиною
 *
 * @param int $hour Година (0-23)
 * @return string Пора доби
 */
function determineTimeOfDay(int $hour): string
{
    if ($hour >= 6 && $hour <= 11) {
        return "Ранок";
    } elseif ($hour >= 12 && $hour <= 17) {
        return "День";
    } elseif ($hour >= 18 && $hour <= 22) {
        return "Вечір";
    } else {
        return "Ніч";
    }
}

// Вхідні дані (v1)
$hour = 14;

// Визначення пори доби
$timeOfDay = determineTimeOfDay($hour);

// Кольори та емодзі для кожної пори
$styles = [
    "Ранок" => ["color" => "#fbbf24", "emoji" => "🌅", "bg" => "#fef3c7"],
    "День" => ["color" => "#3b82f6", "emoji" => "☀️", "bg" => "#dbeafe"],
    "Вечір" => ["color" => "#f97316", "emoji" => "🌆", "bg" => "#ffedd5"],
    "Ніч" => ["color" => "#1e3a5f", "emoji" => "🌙", "bg" => "#1e293b"],
];

$style = $styles[$timeOfDay];
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Завдання 4 — Пора доби (v1)</title>
    <link rel="stylesheet" href="demo.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: <?= $style['bg'] ?>;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s;
            <?= $timeOfDay === "Ніч" ? "color: white;" : "" ?>
        }
        .card {
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 8px 40px rgba(0,0,0,0.2);
            text-align: center;
            max-width: none;
        }
        .emoji { font-size: 80px; margin-bottom: 20px; }
        .time { font-size: 72px; font-weight: bold; color: <?= $style['color'] ?>; }
        .result { font-size: 36px; margin-top: 20px; color: #333; background: none; padding: 0; }
    </style>
</head>
<body>
    <div class="back-button-container" style="position:fixed;top:20px;left:20px;">
        <button onclick="window.location.href='index.php'" class="back-button">← До демо</button>
    </div>
    <div class="card">
        <div class="emoji"><?= $style['emoji'] ?></div>
        <div class="time"><?= sprintf("%02d:00", $hour) ?></div>
        <div class="result"><?= $timeOfDay ?></div>
        <p class="info">Функція: determineTimeOfDay(<?= $hour ?>) = "<?= $timeOfDay ?>"</p>
    </div>
</body>
</html>
