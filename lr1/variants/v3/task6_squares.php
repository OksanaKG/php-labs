<a href="index.php">← Назад</a>
<hr>
<style>
    .area { background: black; width: 500px; height: 300px; position: relative; overflow: hidden; }
    .sq { background: red; position: absolute; border: 1px solid white; }
</style>
<?php
function drawSquares($n) {
    echo "<div class='area'>";
    for ($i = 0; $i < $n; $i++) {
        $size = mt_rand(20, 80);
        $x = mt_rand(0, 420);
        $y = mt_rand(0, 220);
        echo "<div class='sq' style='width:{$size}px; height:{$size}px; left:{$x}px; top:{$y}px;'></div>";
    }
    echo "</div>";
}

echo "<h3>5 червоних квадратів</h3>";
drawSquares(5);
?>