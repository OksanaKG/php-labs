<?php
/**
 * Завдання 5: Голосна/Приголосна (switch)
 *
 * Демонстрація: конструкція switch
 */
require_once __DIR__ . '/layout.php';

/**
 * Визначає чи є літера голосною чи приголосною
 */
function isVowelOrConsonant(string $letter): string
{
    switch (strtolower($letter)) {
        case 'a':
        case 'e':
        case 'i':
        case 'o':
        case 'u':
            return "голосна";
        default:
            return "приголосна";
    }
}

// Вхідні дані (demo)
$letter = 'E';

// Визначення
$result = isVowelOrConsonant($letter);
$isVowel = $result === "голосна";

$color = $isVowel ? "#10b981" : "#8b5cf6";
$emoji = $isVowel ? "🔊" : "🔇";

$content = '<div class="card large">
    <div class="letter-display" style="color:' . $color . '">' . $letter . '</div>
    <div class="letter-emoji" style="color:' . $color . '">' . $emoji . '</div>
    <div class="letter-result">
        Літера <strong>\'' . $letter . '\'</strong> — <span style="color:' . $color . '">' . $result . '</span>
    </div>
    <p class="info">Функція: isVowelOrConsonant(\'' . $letter . '\') = "' . $result . '"</p>
</div>';

renderDemoLayout($content, 'Завдання 5', 'task5-body');
