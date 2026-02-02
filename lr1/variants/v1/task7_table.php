<?php
function generateChessboard(int $n): string {
    $html = "<table class='chessboard'>";
    for ($i = 0; $i < $n; $i++) {
        $html .= "<tr>";
        for ($j = 0; $j < $n; $j++) {
            $color = (($i + $j) % 2 === 0) ? '#fff' : '#000';
            $html .= "<td style='background-color: $color;'></td>";
        }
        $html .= "</tr>";
    }
    $html .= "</table>";
    return $html;
}
$n = 8;
$chessboard = generateChessboard($n);
ob_start();
?>
<div style="text-align:center;">
    <h1 style="color:#333;margin-bottom:30px;">♟️ Шахова дошка <?= $n ?>×<?= $n ?></h1>
    <div class="params">generateChessboard(<?= $n ?>)</div>
    <?= $chessboard ?>
    <p class="info" style="margin-top:20px;">Біла клітинка (0,0) → чергування білих (#fff) та чорних (#000) клітинок</p>
</div>
<?php
$content = ob_get_clean();
require __DIR__.'/layout.php';
renderLayout('<div class="not-implemented">
        <b>Завдання 7.1 не виконано</b>
    </div>');
