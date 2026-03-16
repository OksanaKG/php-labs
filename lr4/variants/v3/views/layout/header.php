<?php
$bgColor = $_SESSION['bg_color'] ?? '#1A1A2E';

// Визначаємо, чи фон світлий чи темний
$rgb = hexToRgb($bgColor);
$brightness = ($rgb['r'] * 299 + $rgb['g'] * 587 + $rgb['b'] * 114) / 1000;
$bgClass = $brightness < 128 ? 'bg-dark-theme' : 'bg-light-theme';

// Додаємо клас для конкретного кольору
$colorClass = '';
switch (strtoupper($bgColor)) {
    case '#1A1A2E':
        $colorClass = 'color-dark-hall';
        break;
    case '#8B0000':
        $colorClass = 'color-velvet';
        break;
    case '#FFD700':
        $colorClass = 'color-gold-screen';
        break;
    case '#FFF8DC':
        $colorClass = 'color-popcorn';
        break;
    case '#2C2C2C':
        $colorClass = 'color-classic-black';
        break;
}

function hexToRgb($hex) {
    $hex = ltrim($hex, '#');
    $length = strlen($hex);
    return [
        'r' => hexdec($length == 6 ? substr($hex, 0, 2) : ($hex[0] . $hex[0])),
        'g' => hexdec($length == 6 ? substr($hex, 2, 2) : ($hex[1] . $hex[1])),
        'b' => hexdec($length == 6 ? substr($hex, 4, 2) : ($hex[2] . $hex[2]))
    ];
}

$greetingName = is_string($_COOKIE['greeting_name'] ?? '') ? ($_COOKIE['greeting_name'] ?? '') : '';
$greetingGender = is_string($_COOKIE['greeting_gender'] ?? '') ? ($_COOKIE['greeting_gender'] ?? '') : '';

$greetingText = '';
if ($greetingName !== '') {
    $title = $greetingGender === 'female' ? 'пані' : 'пане';
    $greetingText = "Вітаємо Вас, {$title} " . htmlspecialchars($greetingName) . "!";
}

$currentRoute = $_GET['route'] ?? 'index/main';

$navItems = [
    'index/main' => 'Головна',
    'regform/form' => 'Реєстрація',
    'reqview/showrequest' => 'Параметри запиту',
    'settings/color' => 'Колір фону',
    'settings/greeting' => 'Привітання',
];
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(($pageTitle ?? '') !== '' ? $pageTitle : 'Кінотеатр') ?> — Кінотеатр</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="background-color: <?= htmlspecialchars($bgColor) ?>" class="<?= htmlspecialchars($bgClass) ?> <?= htmlspecialchars($colorClass) ?>">
    <?php if ($greetingText !== ''): ?>
        <div class="greeting-bar">
            <div class="container">
                <span class="greeting-bar__text"><?= $greetingText ?></span>
            </div>
        </div>
    <?php endif; ?>
    
    <header class="header">
        <div class="container">
            <div class="header__inner">
                <a href="index.php" class="header__logo">🎬 Кінотеатр</a>
            </div>
            <nav class="nav">
                <ul class="nav__list">
                    <?php foreach ($navItems as $route => $label): ?>
                        <li class="nav__item">
                            <a href="index.php?route=<?= $route ?>"
                               class="nav__link<?= $currentRoute === $route ? ' nav__link--active' : '' ?>">
                                <?= htmlspecialchars($label) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="main">
        <div class="container">
