<?php
/**
 * Завдання 2: Виведення форматованого тексту
 *
 * Демонстрація: echo, HTML-теги, стилі
 */
require_once __DIR__ . '/layout.php';

ob_start();
?>
<div class="poem">
    <?php
    echo "<p>Полину в мріях в купель океану,</p>";
    echo "<p>Відчую <b>шовковистість</b> глибини,</p>";
    echo "<p>Чарівні мушлі з дна собі дістану,</p>";
    echo "<p class='poem-indent-1'>Щоб <i>взимку</i></p>";
    echo "<p class='poem-indent-2'>тішили</p>";
    echo "<p class='poem-indent-3'>мене</p>";
    echo "<p class='poem-indent-4'>вони…</p>";
    ?>
</div>
<?php
$content = ob_get_clean();

renderDemoLayout($content, 'Завдання 2', 'task2-body');
