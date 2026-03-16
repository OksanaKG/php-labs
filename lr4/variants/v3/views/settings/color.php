<?php
$colors = $colors ?? [];
$currentColor = $currentColor ?? '#1A1A2E';
$message = $message ?? '';
$messageType = $messageType ?? 'success';
?>

<h1>Колір фону кінотеатру</h1>
<p>Оберіть колір фону для кінотеатру. Зміна зберігається в сесії.</p>

<?php if ($message !== ''): ?>
    <div class="alert alert--<?= $messageType === 'error' ? 'error' : 'success' ?>"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="POST" action="index.php?route=settings/color" class="form">
    <div class="color-picker">
        <?php foreach ($colors as $hex => $name): ?>
            <label class="color-swatch<?= $hex === $currentColor ? ' color-swatch--active' : '' ?>">
                <input type="radio" name="bg_color" value="<?= htmlspecialchars($hex) ?>"
                       <?= $hex === $currentColor ? 'checked' : '' ?>>
                <span class="color-swatch__preview" style="background-color: <?= htmlspecialchars($hex) ?>"></span>
                <span class="color-swatch__name"><?= htmlspecialchars($name) ?></span>
            </label>
        <?php endforeach; ?>
    </div>

    <button type="submit" class="btn">Зберегти</button>
</form>
