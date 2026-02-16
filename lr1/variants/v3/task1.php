<?php
/**
 * Завдання 1: Форматований текст
 *
 * Вірш про осінь з форматуванням: <b>, <i>, margin-left
 */
require_once __DIR__ . '/layout.php';

ob_start();
?>
<div class="poem">
    <?php
    echo "<p style='margin-left: 20px;'>Осінній <b>дощ</b> стукає в шибку,</p>";
    echo "<p style='margin-left: 20px;'>Листя кружляє <i>повільно</i> в дворі,</p>";
    echo "<p style='margin-left: 20px;'>Каштани впали на стежку,</p>";
    echo "<p style='margin-left: 20px;'>Туман лягає на гори.</p>";
    ?>
</div>
<?php
$content = ob_get_clean();

renderVariantLayout($content, 'Завдання 1', 'task1-body');