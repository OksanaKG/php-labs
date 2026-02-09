<?php
/**
 * Home Page - Variant Selection
 * After selecting variant → redirect to variant page
 */

// Dev reload support
require_once __DIR__ . '/shared/helpers/dev_reload.php';
handleDevReloadRequest();

$variants = [];
for ($i = 1; $i <= 15; $i++) {
    $variants["v{$i}"] = "Варіант {$i}";
}

$selectedVariant = $_GET['variant'] ?? '';

// If variant selected, redirect to variant page
if ($selectedVariant && preg_match('/^v\d+$/', $selectedVariant)) {
    // Find first available lab for this variant
    $labs = ['lr1', 'lr2', 'lr3', 'lr4', 'lr6'];
    foreach ($labs as $lab) {
        $path = __DIR__ . "/{$lab}/variants/{$selectedVariant}/index.php";
        if (file_exists($path)) {
            header("Location: /{$lab}/variants/{$selectedVariant}/index.php");
            exit;
        }
    }
    // No lab found for this variant
    $error = "Для {$variants[$selectedVariant]} поки немає доступних лабораторних.";
}
?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <title>PHP Labs — Вибір варіанту</title>
    <link rel="stylesheet" href="shared/css/base.css">
    <style>
    body {
        min-height: 100vh;
        background: linear-gradient(135deg, #e0e7ff 0%, #f3f4f6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .main-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 8px 40px rgba(0, 0, 0, 0.1);
        padding: 50px 40px;
        text-align: center;
        max-width: 400px;
        width: 100%;
    }

    h1 {
        margin: 0 0 10px 0;
        color: #1f2937;
        font-size: 32px;
    }

    .subtitle {
        color: #6b7280;
        margin-bottom: 30px;
        font-size: 16px;
    }

    .variant-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    select {
        font-size: 18px;
        padding: 14px 20px;
        border-radius: 10px;
        border: 2px solid #e2e8f0;
        background: #f8fafc;
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
    }

    select:focus {
        outline: none;
        border-color: #6366f1;
    }

    .btn-go {
        font-size: 18px;
        padding: 14px 24px;
        border-radius: 10px;
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: white;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-go:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
    }

    .error {
        background: #fef2f2;
        color: #991b1b;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }
    </style>
</head>

<body>
    <div class="main-card">
        <h1>PHP Labs</h1>
        <p class="subtitle">Серверні технології</p>

        <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="get" class="variant-form">
            <select name="variant" required>
                <option value="">Оберіть свій варіант...</option>
                <?php foreach ($variants as $key => $name): ?>
                <option value="<?= $key ?>"><?= $name ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn-go">Перейти</button>
        </form>
    </div>
    <?= devReloadScript() ?>
</body>

</html>
