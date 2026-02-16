<a href="index.php">← Назад</a>
<hr>
<?php
$num = 916;
$digits = str_split((string)$num);

echo "<h3>Робота з числом $num</h3>";

// 1. Сума
echo "1. Сума цифр: " . array_sum($digits) . "<br>";

// 2. Реверс
echo "2. Зворотне число: " . strrev($num) . "<br>";

// 3. Найбільше
rsort($digits);
echo "3. Найбільше можливе число: " . implode('', $digits);
?>