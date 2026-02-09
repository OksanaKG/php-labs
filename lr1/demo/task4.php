<?php
/**
 * Завдання 4: Визначення пори року (if-else)
 *
 * Демонстрація: конструкція if-else
 */
require_once __DIR__ . '/layout.php';

/**
 * Визначає пору року за номером місяця
 */
function determineSeason(int $month): string
{
    if ($month >= 3 && $month <= 5) {
        return "Весна";
    } elseif ($month >= 6 && $month <= 8) {
        return "Літо";
    } elseif ($month >= 9 && $month <= 11) {
        return "Осінь";
    } else {
        return "Зима";
    }
}

// Вхідні дані (demo)
$month = 7;

// Визначення пори року
$season = determineSeason($month);

// Назви місяців
$monthNames = [
    1 => "Січень", 2 => "Лютий", 3 => "Березень",
    4 => "Квітень", 5 => "Травень", 6 => "Червень",
    7 => "Липень", 8 => "Серпень", 9 => "Вересень",
    10 => "Жовтень", 11 => "Листопад", 12 => "Грудень"
];

// Кольори та емодзі для кожної пори
$styles = [
    "Весна" => ["class" => "spring", "color" => "#10b981", "emoji" => "🌸"],
    "Літо" => ["class" => "summer", "color" => "#f59e0b", "emoji" => "☀️"],
    "Осінь" => ["class" => "autumn", "color" => "#f97316", "emoji" => "🍂"],
    "Зима" => ["class" => "winter", "color" => "#3b82f6", "emoji" => "❄️"],
];

$style = $styles[$season];

$content = '<div class="card large">
    <div class="season-emoji">' . $style['emoji'] . '</div>
    <div class="season-month" style="color:' . $style['color'] . '">Місяць ' . $month . '</div>
    <div class="season-month-name">' . $monthNames[$month] . '</div>
    <div class="season-result">' . $season . '</div>
    <p class="info">Функція: determineSeason(' . $month . ') = "' . $season . '"</p>
</div>';

renderDemoLayout($content, 'Завдання 4', 'task4-body ' . $style['class']);
