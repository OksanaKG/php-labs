<?php
$colors = $colors ?? [];
$currentColor = $currentColor ?? 'color-dark-hall';
$message = $message ?? '';
$error = $error ?? '';

$colorMap = [
    'color-dark-hall' => '#191970',
    'color-velvet' => '#800020',
    'color-gold-screen' => '#FFD700',
    'color-popcorn' => '#FFF8DC',
    'color-classic-black' => '#2F2F2F',
];
?>

<h1>Колір фону (Сесії)</h1>

<p>Оберіть колір фону сторінки. Значення зберігається в <code>$_SESSION</code> та діє на всіх сторінках до закриття браузера.</p>

<?php if ($error !== ''): ?>
    <div class="alert alert--error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if ($message !== ''): ?>
    <div class="alert alert--success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="POST" action="index.php?route=settings/color" class="form">
    <div class="color-picker">
        <?php foreach ($colors as $class => $label): ?>
            <label class="color-swatch <?= $currentColor === $class ? 'color-swatch--active' : '' ?>">
                <input type="radio" name="bg_color" value="<?= htmlspecialchars($class) ?>"
                    <?= $currentColor === $class ? 'checked' : '' ?>>
                <span class="color-swatch__preview" style="background-color: <?= htmlspecialchars($colorMap[$class] ?? '#000') ?>"></span>
                <span class="color-swatch__name"><?= htmlspecialchars($label) ?></span>
            </label>
        <?php endforeach; ?>
    </div>

    <div class="form__actions">
        <button type="submit" class="btn">Зберегти колір</button>
    </div>
</form>

<p class="text-muted text-muted--mt">Модуль успадковано з ЛР4. Також доступне <a href="index.php?route=settings/greeting">привітання через Cookie</a>.</p>
