<?php
/**
 * Завдання 9: Асоціативний масив
 *
 * Варіант 3: ім'я => вік
 * Сортування: ksort (за іменем), asort (за віком)
 */
require_once __DIR__ . '/layout.php';

/**
 * Сортує асоціативний масив за іменами (ключами)
 */
function sortByName(array $people): array
{
    ksort($people);
    return $people;
}

/**
 * Сортує асоціативний масив за віком (значеннями)
 */
function sortByAge(array $people): array
{
    asort($people);
    return $people;
}

// Дані (варіант 3)
$people = [
    "Галина" => 37,
    "Петро" => 24,
    "Людмила" => 52,
    "Олександр" => 18,
    "Віталій" => 43,
    "Софія" => 30,
    "Роман" => 61,
    "Анна" => 25,
];

// Обробка
$sortBy = $_POST['sort'] ?? $_GET['sort'] ?? 'name';
$sorted = $sortBy === 'age' ? sortByAge($people) : sortByName($people);

ob_start();
?>
<div class="demo-card">
    <h2>Асоціативний масив</h2>
    <p class="demo-subtitle">Сортування за іменем або за віком</p>

    <div class="flex-buttons">
        <form method="post">
            <input type="hidden" name="sort" value="name">
            <button type="submit" class="<?= $sortBy === 'name' ? 'btn-submit' : 'btn-secondary' ?>">За іменем (ksort)</button>
        </form>
        <form method="post">
            <input type="hidden" name="sort" value="age">
            <button type="submit" class="<?= $sortBy === 'age' ? 'btn-submit' : 'btn-secondary' ?>">За віком (asort)</button>
        </form>
    </div>

    <div class="demo-section">
        <h3>Вхідні дані</h3>
        <div class="demo-code">$people = [
<?php foreach ($people as $name => $age): ?>
    "<?= $name ?>" => <?= $age ?>,
<?php endforeach; ?>
];</div>
    </div>

    <div class="demo-section">
        <h3>Відсортовано: <span class="demo-tag demo-tag-primary"><?= $sortBy === 'age' ? 'за віком (asort)' : 'за іменем (ksort)' ?></span></h3>
        <table class="demo-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ім'я <?= $sortBy === 'name' ? '&#8593;' : '' ?></th>
                    <th>Вік <?= $sortBy === 'age' ? '&#8593;' : '' ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($sorted as $name => $age): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($name) ?></td>
                    <td><span class="demo-tag demo-tag-success"><?= $age ?> років</span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="demo-code"><?= $sortBy === 'age' ? 'sortByAge' : 'sortByName' ?>($people);
// <?= $sortBy === 'age' ? 'asort($people) — сортування за значеннями (віком)' : 'ksort($people) — сортування за ключами (іменами)' ?></div>
</div>
<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 9');
