<a href="index.php">← Назад</a>
<hr>
<?php
$char = 'о';
$char_lower = mb_strtolower($char, 'UTF-8');

echo "<h3>Голосна чи приголосна</h3>";
echo "Символ: '$char' — ";

switch ($char_lower) {
    case 'а': case 'е': case 'є': case 'и': case 'і': 
    case 'ї': case 'о': case 'у': case 'ю': case 'я':
        echo "<b>голосна</b>";
        break;
    default:
        echo "<b>приголосна</b>";
}
?>