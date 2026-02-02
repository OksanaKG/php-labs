<?php
require_once __DIR__.'/tasks/task3.php';
$eur = 250;
$rate = 45.20;
$uah = convertEurToUah($eur, $rate);
$result = formatConversionResult($eur, $uah);
$content = '<div class="card container-400">
    <h2>💶 Конвертер EUR → UAH</h2>
    <p><strong>Курс:</strong> 1 EUR = ' . $rate . ' грн</p>
    <div class="result">' . $result . '</div>
    <p class="info">Функція: convertEurToUah(' . $eur . ', ' . $rate . ') = ' . $uah . '</p>
</div>';
require __DIR__.'/layout.php';
renderLayout($content);