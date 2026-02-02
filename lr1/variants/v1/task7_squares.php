<?php
function generateRandomCircles(int $n): string {
    $html = "<div class='container' style='position:relative; width:100vw; height:100vh; background:#0066cc;'>";
    for ($i = 0; $i < $n; $i++) {
        $size = mt_rand(20, 80);
        $top = mt_rand(5, 85);
        $left = mt_rand(5, 85);
        $opacity = mt_rand(70, 100) / 100;
        $html .= "<div class='circle' style='position:absolute;width:{$size}px;height:{$size}px;top:{$top}%;left:{$left}%;background:yellow;border-radius:50%;opacity:{$opacity};box-shadow:0 4px 20px rgba(255,255,0,0.4);transition:transform 0.3s,box-shadow 0.3s;'></div>";
    }
    $html .= "</div>";
    return $html;
}
$n = 12;
$circles = generateRandomCircles($n);
ob_start();
?>
<?= $circles ?>
<div class="circles-func">generateRandomCircles(<?= $n ?>)</div>
<div class="circles-counter">🟡 Кіл: <?= $n ?></div>
<p class="circles-info">Наведіть курсор на коло для анімації. Оновіть сторінку для нової композиції.</p>
<?php
$content = ob_get_clean();
require __DIR__.'/layout.php';
renderLayout(
     '<div class="not-implemented">
          <b>Завдання 7.2 не виконано</b>
     </div>'
);
