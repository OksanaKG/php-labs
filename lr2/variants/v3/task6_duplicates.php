<?php
/**
 * Завдання 6: Пошук дублікатів
 *
 * Варіант 3: знаходить усі елементи, що повторюються більше ніж один раз
 * Масив: [9, 1, 5, 9, 3, 7, 1, 5, 11, 3, 7, 15] → [9, 1, 5, 3, 7]
 */
require_once __DIR__ . '/layout.php';

/**
 * Знаходить усі дублікати (елементи, що повторюються більше ніж один раз)
 *
 * @param array $arr Вхідний масив
 * @return array Массив унікальних дублікатів
 */
function findDuplicates(array $arr): array
{
    if (empty($arr)) {
        return [];
    }

    $counts = array_count_values($arr);
    $duplicates = array_keys(array_filter($counts, fn($count) => $count > 1));
    
    // Зберігаємо порядок першого виявлення
    $result = [];
    foreach ($arr as $item) {
        if (in_array($item, $duplicates) && !in_array($item, $result)) {
            $result[] = $item;
        }
    }
    
    return $result;
}

// Обробка форми (варіант 3)
$input = $_POST['array'] ?? '9, 1, 5, 9, 3, 7, 1, 5, 11, 3, 7, 15';
$submitted = isset($_POST['array']);

$arr = array_map('trim', explode(',', $input));
$arr = array_filter($arr, fn($v) => $v !== '');

$duplicates = findDuplicates($arr);

ob_start();
?>
<div class="demo-card">
    <h2>Пошук дублікатів</h2>
    <p class="demo-subtitle">Знаходить усі елементи, що повторюються в масиві</p>

    <form method="post" class="demo-form">
        <div>
            <label for="array">Масив (через кому)</label>
            <input type="text" id="array" name="array" value="<?= htmlspecialchars($input) ?>" placeholder="9, 1, 5, 9, 3, 7">
        </div>
        <button type="submit" class="btn-submit">Знайти дублікати</button>
    </form>

    <?php if (!empty($arr)): ?>
    <div class="demo-section">
        <h3>Вхідний масив</h3>
        <div class="array-display">
            <?php foreach ($arr as $item): ?>
            <span class="array-item <?= in_array($item, $duplicates) ? 'array-item-unique' : '' ?>"><?= htmlspecialchars($item) ?></span>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if (!empty($duplicates)): ?>
    <div class="demo-result">
        <h3>Дублікати</h3>
        <div class="demo-result-value">[<?= htmlspecialchars(implode(', ', $duplicates)) ?>]</div>
    </div>

    <div class="demo-section">
        <h3>Деталі</h3>
        <table class="demo-table">
            <thead>
                <tr>
                    <th>Елемент</th>
                    <th>Кількість входжень</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $counts = array_count_values($arr);
                foreach ($duplicates as $dup):
                ?>
                <tr>
                    <td><?= htmlspecialchars($dup) ?></td>
                    <td><?= $counts[$dup] ?></td>
                    <td><span class="demo-tag demo-tag-success">Дублікат</span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="demo-result demo-result-info">
        <h3>Результат</h3>
        <div class="demo-result-value">Дублікатів не знайдено</div>
    </div>
    <?php endif; ?>

    <div class="demo-code">findDuplicates([<?= htmlspecialchars(implode(', ', $arr)) ?>])
// Результат: [<?= htmlspecialchars(implode(', ', $duplicates)) ?>]</div>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 6');
