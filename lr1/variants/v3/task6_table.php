<a href="index.php">← Назад</a>
<hr>
<style>
    table { border-collapse: collapse; }
    td { width: 40px; height: 40px; border: 1px solid #333; }
</style>
<?php
function drawTable($rows, $cols) {
    echo "<table>";
    for ($i = 0; $i < $rows; $i++) {
        echo "<tr>";
        for ($j = 0; $j < $cols; $j++) {
            $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            echo "<td style='background-color: $color;'></td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}

echo "<h3>Таблиця 3x6</h3>";
drawTable(3, 6);
?>