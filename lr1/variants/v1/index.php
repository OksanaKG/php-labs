<?php
/**
 * Variant 1 Index Page
 * Shows task cards with Demo link
 */

$config = require __DIR__ . '/config.php';
require_once dirname(__DIR__, 3) . '/shared/templates/task_cards.php';

$variantName = $config['variantName'];
$variant = $config['variant'];
$lab = $config['lab'];
$tasks = $config['tasks'];
$demoUrl = "/{$lab}/demo/index.php?from={$variant}";
?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($variantName) ?> — Завдання</title>
    <link rel="stylesheet" href="../shared/style.css">
</head>

<body class="index-page">
    <header class="header-fixed">
        <div class="header-left">
            <a href="/" class="header-btn">Головна</a>
        </div>
        <div class="header-center"></div>
        <div class="header-right">
            <?= htmlspecialchars($variantName) ?>
        </div>
    </header>

    <h1 class="index-title">
        <?= htmlspecialchars($variantName) ?>
        <br><span class="index-subtitle">Оберіть завдання</span>
    </h1>

    <?= renderTaskCards($tasks, true, $demoUrl) ?>
</body>

</html>