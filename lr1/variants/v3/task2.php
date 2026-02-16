<a href="index.php">← Назад</a>
<hr>
<?php
$uah = 25000;
$rate = 42.10;
$usd = $uah / $rate;

echo "<h3>Конвертер валют</h3>";
echo "$uah грн. можна обміняти на " . number_format($usd, 2, '.', '') . " долар";
?>