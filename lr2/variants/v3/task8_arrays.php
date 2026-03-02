<?php
/**
 * Завдання 8: Операції з масивами
 *
 * Варіант 3: array_merge + array_unique + sort ascending
 * createArray(): довжина 3-7, значення 10-20
 */
require_once __DIR__ . '/layout.php';

/**
 * Створює масив випадкової довжини (3-7) з випадковими значеннями (10-20)
 */
function createArray(): array
{
    $length = random_int(3, 7);
    $arr = [];
    for ($i = 0; $i < $length; $i++) {
        $arr[] = random_int(10, 20);
    }
    return $arr;
}

/**
 * Об'єднує два масиви, видаляє дублікати і сортує за зростанням
 */
function mergeSorted(array $a, array $b): array
{
    $merged = array_merge($a, $b);
    $unique = array_unique($merged);
    sort($unique);
    return array_values($unique);
}

// Генеруємо масиви (варіант 3)
if (isset($_POST['regenerate'])) {
    $_SESSION['arr1'] = createArray();
    $_SESSION['arr2'] = createArray();
} else {
    $_SESSION['arr1'] = $_SESSION['arr1'] ?? createArray();
    $_SESSION['arr2'] = $_SESSION['arr2'] ?? createArray();
}

$arr1 = $_SESSION['arr1'];
$arr2 = $_SESSION['arr2'];

$result = mergeSorted($arr1, $arr2);

ob_start();
?>
<div class="demo-card demo-card-wide">
    <h2>Операції з масивами</h2>
    <p class="demo-subtitle">createArray(), об'єднання (array_merge), видалення дублікатів (array_unique), сортування за зростанням</p>

    <form method="post" class="demo-form">
        <button type="submit" name="regenerate" class="btn-submit">Згенерувати нові масиви</button>
    </form>

    <div class="demo-section">
        <h3>Масив 1</h3>
        <div class="array-display">
            <?php foreach ($arr1 as $v): ?>
            <span class="array-item"><?= $v ?></span>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="demo-section">
        <h3>Масив 2</h3>
        <div class="array-display">
            <?php foreach ($arr2 as $v): ?>
            <span class="array-item"><?= $v ?></span>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="array-arrow">&#8595; array_merge($a, $b)</div>

    <div class="demo-section">
        <h3>Об'єднано (з дублікатами)</h3>
        <div class="array-display">
            <?php 
            $merged = array_merge($arr1, $arr2);
            foreach ($merged as $v): ?>
            <span class="array-item <?= count(array_filter($merged, fn($x) => $x == $v)) > 1 ? 'array-item-dup' : '' ?>"><?= $v ?></span>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="array-arrow">&#8595; array_unique() + sort()</div>

    <div>
        <h3 class="demo-section-title-success">Результат (видалені дублікати, відсортований)</h3>
        <div class="array-display">
            <?php foreach ($result as $v): ?>
            <span class="array-item array-item-unique"><?= $v ?></span>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="demo-code">$a = createArray(); // [<?= implode(', ', $arr1) ?>]
$b = createArray(); // [<?= implode(', ', $arr2) ?>]
mergeSorted($a, $b);
// array_merge → array_unique → sort
// Результат: [<?= implode(', ', $result) ?>]</div>

    <style>
        .array-item-dup {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ef5350;
        }
    </style>
</div>
<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 8');
