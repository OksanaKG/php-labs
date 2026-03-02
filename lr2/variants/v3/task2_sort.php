<?php
/**
 * Завдання 2: Сортування міст
 *
 * Варіант 3: За алфавітом (A-Z)
 */
require_once __DIR__ . '/layout.php';

/**
 * Сортує міста в алфавітному порядку
 */
function sortCities(string $input): array
{
    $cities = array_filter(array_map('trim', explode(' ', $input)));
    sort($cities);
    return $cities;
}

// Вхідні дані (варіант 3)
$input = $_POST['cities'] ?? '';
$submitted = isset($_POST['cities']);
$defaultCities = 'Запоріжжя Дніпро Миколаїв Херсон Біла Церква Кременчук Маріуполь Мелітополь';

if (!$submitted) {
    $input = $defaultCities;
}

$sorted = sortCities($input);

ob_start();
?>
<div class="demo-card">
    <h2>Сортування міст</h2>
    <p class="demo-subtitle">Введіть назви міст через пробіл — сортування від А до Я</p>

    <form method="post" class="demo-form">
        <div>
            <label for="cities">Міста (через пробіл)</label>
            <input type="text" id="cities" name="cities" value="<?= htmlspecialchars($input) ?>" placeholder="Запоріжжя Дніпро Миколаїв">
        </div>
        <button type="submit" class="btn-submit">Сортувати</button>
    </form>

    <?php if (!empty($sorted)): ?>
    <div class="demo-section">
        <h3>Вхідні дані</h3>
        <div class="array-display">
            <?php foreach (array_filter(array_map('trim', explode(' ', $input))) as $city): ?>
            <span class="array-item"><?= htmlspecialchars($city) ?></span>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="array-arrow">&#8595;</div>

    <div>
        <h3 class="demo-section-title-success">Відсортовані (А→Я)</h3>
        <div class="array-display">
            <?php foreach ($sorted as $city): ?>
            <span class="array-item array-item-unique"><?= htmlspecialchars($city) ?></span>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="demo-code">sortCities("<?= htmlspecialchars($input) ?>")
// sort() — алфавітний порядок
// Результат: [<?= htmlspecialchars(implode(', ', array_map(fn($c) => "\"$c\"", $sorted))) ?>]</div>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 2');
