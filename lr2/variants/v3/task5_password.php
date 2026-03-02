<?php
/**
 * Завдання 5: Генератор паролів
 *
 * Варіант 3: довжина 8, перевірка складності (0-5 балів)
 * Вимоги: 1 велика, 1 мала, 1 цифра, 1 спецсимвол (!@#$%^&*()-_=+)
 */
require_once __DIR__ . '/layout.php';

function generatePassword(int $length = 8): string
{
    $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lower = 'abcdefghijklmnopqrstuvwxyz';
    $digits = '0123456789';
    $special = '!@#$%^&*()-_=+';
    $all = $upper . $lower . $digits . $special;

    $password = '';
    // Гарантуємо наявність кожного типу символу
    $password .= $upper[random_int(0, strlen($upper) - 1)];
    $password .= $lower[random_int(0, strlen($lower) - 1)];
    $password .= $digits[random_int(0, strlen($digits) - 1)];
    $password .= $special[random_int(0, strlen($special) - 1)];

    // Заповнюємо решту довжини випадковими символами
    for ($i = 4; $i < $length; $i++) {
        $password .= $all[random_int(0, strlen($all) - 1)];
    }

    return str_shuffle($password);
}

function checkPasswordStrength(string $password): array
{
    $checks = [
        'length' => ['label' => 'Довжина >= 8 символів', 'passed' => strlen($password) >= 8],
        'upper' => ['label' => 'Містить велику літеру', 'passed' => (bool)preg_match('/[A-Z]/', $password)],
        'lower' => ['label' => 'Містить малу літеру', 'passed' => (bool)preg_match('/[a-z]/', $password)],
        'digit' => ['label' => 'Містить цифру', 'passed' => (bool)preg_match('/[0-9]/', $password)],
        'special' => ['label' => 'Містить спецсимвол', 'passed' => (bool)preg_match('/[!@#$%^&*\(\)\-_=+]/', $password)],
    ];

    $score = array_reduce($checks, fn(int $acc, array $check) => $acc + ($check['passed'] ? 1 : 0), 0);

    $strength = match (true) {
        $score <= 1 => 'weak',
        $score <= 2 => 'fair',
        $score <= 3 => 'good',
        default => 'strong',
    };

    $strengthLabels = [
        'weak' => 'Слабкий',
        'fair' => 'Задовільний',
        'good' => 'Добрий',
        'strong' => 'Надійний',
    ];

    return [
        'strength' => $strength,
        'strengthLabel' => $strengthLabels[$strength],
        'score' => $score,
        'total' => count($checks),
        'checks' => $checks,
    ];
}

// Обробка (варіант 3)
$action = $_POST['action'] ?? '';
$genLength = (int)($_POST['gen_length'] ?? 8);
$checkPassword = $_POST['check_password'] ?? '';
$generated = '';
$strengthResult = null;

if ($genLength < 8) $genLength = 8;
if ($genLength > 64) $genLength = 64;

if ($action === 'generate') {
    $generated = generatePassword($genLength);
    $strengthResult = checkPasswordStrength($generated);
} elseif ($action === 'check' && $checkPassword !== '') {
    $strengthResult = checkPasswordStrength($checkPassword);
}

ob_start();
?>
<div class="demo-card demo-card-wide">
    <h2>Генератор паролів</h2>
    <p class="demo-subtitle">Генерація надійного пароля та перевірка його складності (0-5 балів)</p>

    <div class="demo-grid-2">
        <!-- Генератор -->
        <div class="demo-panel">
            <h3 class="demo-panel-title-primary">Генератор</h3>
            <form method="post" class="demo-form">
                <input type="hidden" name="action" value="generate">
                <div>
                    <label for="gen_length">Довжина пароля</label>
                    <input type="number" id="gen_length" name="gen_length" value="<?= $genLength ?>" min="8" max="64">
                </div>
                <button type="submit" class="btn-submit">Згенерувати</button>
            </form>

            <?php if ($generated): ?>
            <div class="demo-result mt-15">
                <h3>Згенерований пароль</h3>
                <div class="demo-result-value demo-mono"><?= htmlspecialchars($generated) ?></div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Перевірка -->
        <div class="demo-panel">
            <h3 class="demo-panel-title-success">Перевірка міцності</h3>
            <form method="post" class="demo-form">
                <input type="hidden" name="action" value="check">
                <div>
                    <label for="check_password">Пароль для перевірки</label>
                    <input type="text" id="check_password" name="check_password" value="<?= htmlspecialchars($checkPassword) ?>" placeholder="Введіть пароль">
                </div>
                <button type="submit" class="btn-submit btn-success">Перевірити</button>
            </form>
        </div>
    </div>

    <?php if ($strengthResult): ?>
    <div class="demo-section">
        <h3>Результат перевірки: <span class="demo-tag demo-tag-<?= match($strengthResult['strength']) {
            'weak' => 'error',
            'fair' => 'warning',
            'good' => 'primary',
            'strong' => 'success',
        } ?>"><?= htmlspecialchars($strengthResult['strengthLabel']) ?></span> (<?= $strengthResult['score'] ?>/<?= $strengthResult['total'] ?> балів)</h3>

        <div class="strength-meter">
            <div class="strength-meter-fill strength-<?= $strengthResult['strength'] ?>"></div>
        </div>

        <table class="demo-table mt-15">
            <thead>
                <tr>
                    <th>Критерій</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($strengthResult['checks'] as $check): ?>
                <tr>
                    <td><?= htmlspecialchars($check['label']) ?></td>
                    <td>
                        <?php if ($check['passed']): ?>
                        <span class="demo-tag demo-tag-success">✓ Так</span>
                        <?php else: ?>
                        <span class="demo-tag demo-tag-error">✗ Ні</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="demo-code">generatePassword(<?= $genLength ?>)
// Результат: "<?= htmlspecialchars($generated ?: $checkPassword) ?>"
// Бали: <?= $strengthResult['score'] ?>/5 (<?= $strengthResult['strength'] ?>)</div>
    </div>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 5');
