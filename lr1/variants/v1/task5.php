<?php
function isEvenOrOdd(int $digit): string {
    switch ($digit) {
        case 0: case 2: case 4: case 6: case 8: return "парна";
        case 1: case 3: case 5: case 7: case 9: return "непарна";
        default: return "невідомо";
    }
}
$digit = 7;
$result = isEvenOrOdd($digit);
$isEven = $result === "парна";
$color = $isEven ? "#10b981" : "#ef4444";
$emoji = $isEven ? "✓" : "✗";
ob_start();
?>
<div class="card">
    <div class="digit-large" style="color:<?= $color ?>;">
        <?= $digit ?>
    </div>
    <div class="emoji" style="color:<?= $color ?>;"><?= $emoji ?></div>
    <div class="result-text" style="font-size:28px;">
        Цифра <strong><?= $digit ?></strong> — <span style="color:<?= $color ?>"><?= $result ?></span>
    </div>
    <p class="info">Функція: isEvenOrOdd(<?= $digit ?>) = "<?= $result ?>"</p>
</div>
<?php
$content = ob_get_clean();
require __DIR__.'/layout.php';
renderLayout(
    '<div class="not-implemented">
        <b>Завдання 5 не виконано</b>
    </div>'
);
