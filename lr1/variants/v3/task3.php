<a href="index.php">← Назад</a>
<hr>
<?php
$month = 11;
echo "<h3>Визначення сезону</h3>";
echo "Місяць: $month — ";

if ($month == 12 || $month == 1 || $month == 2) {
    echo "<b>зима</b>";
} elseif ($month >= 3 && $month <= 5) {
    echo "<b>весна</b>";
} elseif ($month >= 6 && $month <= 8) {
    echo "<b>літо</b>";
} elseif ($month >= 9 && $month <= 11) {
    echo "<b>осінь</b>";
} else {
    echo "невідомий місяць";
}
?>