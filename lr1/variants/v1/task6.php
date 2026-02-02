<?php
function sumOfDigits(int $number): int { $sum=0; while($number>0){$sum+=$number%10;$number=(int)($number/10);} return $sum; }
function productOfDigits(int $number): int { $product=1; while($number>0){$product*=$number%10;$number=(int)($number/10);} return $product; }
function reverseNumber(int $number): int { $reversed=0; while($number>0){$reversed=$reversed*10+$number%10;$number=(int)($number/10);} return $reversed; }
function maxFromDigits(int $number): int { $digits=[]; while($number>0){$digits[]=$number%10;$number=(int)($number/10);} rsort($digits); $result=0; foreach($digits as $digit){$result=$result*10+$digit;} return $result; }
$number = mt_rand(1000, 9999);
$d1 = (int)($number / 1000);
$d2 = (int)(($number % 1000) / 100);
$d3 = (int)(($number % 100) / 10);
$d4 = $number % 10;
$sum = sumOfDigits($number);
$product = productOfDigits($number);
$reversed = reverseNumber($number);
$maxNum = maxFromDigits($number);
ob_start();
?>
<div class="container-500">
    <div class="card">
        <h3>🎲 Випадкове чотиризначне число</h3>
        <div class="number"><?= $number ?></div>
        <div class="digits">
            <div class="digit"><?= $d1 ?></div>
            <div class="digit"><?= $d2 ?></div>
            <div class="digit"><?= $d3 ?></div>
            <div class="digit"><?= $d4 ?></div>
        </div>
    </div>
    <div class="card" style="margin-top:20px;">
        <h3>📊 Результати</h3>
        <div class="result-row">
            <div>
                <span>1. Сума цифр</span>
                <div class="func">sumOfDigits(<?= $number ?>)</div>
            </div>
            <span class="result-value"><?= $sum ?></span>
        </div>
        <div class="result-row">
            <div>
                <span>2. Добуток цифр</span>
                <div class="func">productOfDigits(<?= $number ?>)</div>
            </div>
            <span class="result-value"><?= $product ?></span>
        </div>
        <div class="result-row">
            <div>
                <span>3. В зворотному порядку</span>
                <div class="func">reverseNumber(<?= $number ?>)</div>
            </div>
            <span class="result-value"><?= $reversed ?></span>
        </div>
        <div class="result-row">
            <div>
                <span>4. Найбільше можливе</span>
                <div class="func">maxFromDigits(<?= $number ?>)</div>
            </div>
            <span class="result-value"><?= $maxNum ?></span>
        </div>
    </div>
    <p class="hint">Оновіть сторінку для нового числа 🔄</p>
</div>
<?php
$content = ob_get_clean();
require __DIR__.'/layout.php';
renderLayout($content);
