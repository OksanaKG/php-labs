<?php
// Головна сторінка для вибору варіанту та лабораторної
// Всі лабораторні та варіанти
$labs = [
    'lr1' => 'ЛР1',
    'lr2' => 'ЛР2',
    'lr3' => 'ЛР3',
    'lr4' => 'ЛР4',
    'lr6' => 'ЛР6',
];
$variants = [
    'v1' => 'Варіант 1',
    'v2' => 'Варіант 2',
];

$selectedVariant = $_GET['variant'] ?? '';
$selectedLab = $_GET['lab'] ?? '';

function fileExistsForLabVariant($lab, $variant) {
    $path = __DIR__ . "/$lab/variants/$variant/task2.php";
    return file_exists($path);
}

if ($selectedVariant && $selectedLab) {
    if (fileExistsForLabVariant($selectedLab, $selectedVariant)) {
        header("Location: /$selectedLab/variants/$selectedVariant/task2.php");
        exit;
    } else {
        http_response_code(404);
        echo '<!DOCTYPE html><html lang="uk"><head><meta charset="UTF-8"><title>404 Не знайдено</title><link rel="stylesheet" href="lr1/variants/v1/style.css"><style>.main-select{max-width:400px;margin:120px auto 0 auto;background:#fff;border-radius:16px;box-shadow:0 4px 32px rgba(0,0,0,0.08);padding:40px 30px 30px 30px;text-align:center;}h1{margin-bottom:30px;color:#c00;}button{font-size:18px;padding:8px 18px;border-radius:8px;border:1px solid #cbd5e1;margin:10px 0 20px 0;background:#6366f1;color:white;cursor:pointer;}button:hover{background:#4338ca;}</style></head><body><div class="main-select"><h1>404: Не знайдено</h1><p>Обрана лабораторна або варіант ще не реалізовані.</p><button onclick="window.location.href='/'">Повернутися</button></div></body></html>';
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <title>Вибір варіанту та лабораторної</title>
    <link rel="stylesheet" href="lr1/variants/v1/style.css">
    <style>
    .main-select {
        max-width: 400px;
        margin: 120px auto 0 auto;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 32px rgba(0, 0, 0, 0.08);
        padding: 40px 30px 30px 30px;
        text-align: center;
    }

    h1 {
        margin-bottom: 30px;
        color: #333;
    }

    select,
    button {
        font-size: 18px;
        padding: 8px 18px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        margin: 10px 0 20px 0;
    }

    button {
        background: #6366f1;
        color: white;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background: #4338ca;
    }
    </style>
    <script>
    function updateLabs() {
        document.getElementById('lab-select').disabled = !document.getElementById('variant-select').value;
    }
    </script>
</head>

<body>
    <div class="main-select">
        <h1>Виберіть варіант і лабораторну</h1>
        <form method="get">
            <label for="variant-select">Варіант:</label><br>
            <select id="variant-select" name="variant" onchange="updateLabs()" required>
                <option value="">Оберіть варіант…</option>
                <?php foreach ($variants as $key => $name): ?>
                <option value="<?= $key ?>" <?= $selectedVariant===$key?'selected':'' ?>><?= $name ?></option>
                <?php endforeach; ?>
            </select><br>
            <label for="lab-select">Лабораторна:</label><br>
            <select id="lab-select" name="lab" <?= $selectedVariant?'':'disabled' ?> required>
                <option value="">Оберіть лабораторну…</option>
                <?php foreach ($labs as $key => $name): ?>
                <option value="<?= $key ?>" <?= $selectedLab===$key?'selected':'' ?>><?= $name ?></option>
                <?php endforeach; ?>
            </select><br>
            <button type="submit">Перейти</button>
        </form>
    </div>
    <script>
    updateLabs();
    </script>
</body>

</html>