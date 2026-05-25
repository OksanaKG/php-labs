<?php
$bgColor = $_SESSION['bg_color'] ?? 'color-dark-hall';
$bodyClass = $bgColor;
$greetingName = $_COOKIE['greeting_name'] ?? '';
$greetingGender = $_COOKIE['greeting_gender'] ?? '';

$greetingText = '';
if ($greetingName !== '') {
    $title = $greetingGender === 'female' ? 'пані' : 'пане';
    $greetingText = "Вітаємо Вас, {$title} " . htmlspecialchars($greetingName) . "!";
}

$isLoggedIn = isset($_SESSION['user_id']);
$userLogin = $_SESSION['user_login'] ?? '';

$currentRoute = $_GET['route'] ?? 'index/main';

$navItems = [
    'index/main' => 'Головна',
    'guestbook/index' => 'Гостьова книга',
    'folder/create' => 'Товари',
    'movie/list' => 'Фільми',
    'movie/my_tickets' => 'Мої квитки',
        'admin/index' => 'Адмін',
    'settings/color' => 'Налаштування',
];
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Кінотеатр') ?> — Кінотеатр</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="<?= htmlspecialchars($bodyClass) ?>">
    <header class="header">
        <div class="container">
            <div class="header__inner">
                <a href="index.php" class="header__logo">Кінотеатр</a>
                <div class="header__right">
                    <?php if ($greetingText !== ''): ?>
                        <span class="header__greeting"><?= $greetingText ?></span>
                    <?php endif; ?>
                        <button id="themeToggleHeader" class="header__theme-toggle" title="Toggle theme">🌙</button>
                        <div class="header__auth">
                            <?php if ($isLoggedIn): ?>
                                <a href="index.php?route=auth/logout" class="header__auth-link header__auth-link--logout">Вийти</a>
                            <?php else: ?>
                                <a href="index.php?route=auth/login" class="header__auth-link">Увійти</a>
                                <a href="index.php?route=auth/register" class="header__auth-link">Реєстрація</a>
                            <?php endif; ?>
                        </div>
                </div>
            </div>
                    <nav class="nav">
                        <ul class="nav__list">
                            <?php foreach ($navItems as $route => $label): ?>
                                <?php if ($route === 'movie/my_tickets' && !isset($_SESSION['user_id'])) continue; ?>
                                <?php if ($route === 'admin/index' && !(isset($_SESSION['user_id']) && $_SESSION['user_id'] === 1)) continue; ?>
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
    <main class="main" id="main-content">
        <div class="container">
            <?php
            if (!empty($_SESSION['flash_success'])):
                $flash = $_SESSION['flash_success'];
                unset($_SESSION['flash_success']);
            ?>
                <div class="alert alert--success" role="alert"><?= htmlspecialchars($flash) ?></div>
            <?php endif; ?>
    <script>
        (function(){
            const btn = document.getElementById('themeToggleHeader');
            function updateIcon(){ if (btn) btn.textContent = document.body.classList.contains('bg-light-theme') ? '🌙' : '☀️'; }
            // initialize from localStorage or body class
            const stored = localStorage.getItem('siteTheme');
            if (stored === 'light') { document.body.classList.add('bg-light-theme'); document.body.classList.remove('bg-dark-theme'); }
            else if (stored === 'dark') { document.body.classList.add('bg-dark-theme'); document.body.classList.remove('bg-light-theme'); }
            else {
                // default to dark theme for better contrast
                if (!document.body.classList.contains('bg-dark-theme') && !document.body.classList.contains('bg-light-theme')) {
                    document.body.classList.add('bg-dark-theme');
                }
            }
            updateIcon();
            if (btn) {
                btn.addEventListener('click', function(){
                    if (document.body.classList.contains('bg-light-theme')) {
                        document.body.classList.remove('bg-light-theme');
                        document.body.classList.add('bg-dark-theme');
                        localStorage.setItem('siteTheme','dark');
                    } else {
                        document.body.classList.remove('bg-dark-theme');
                        document.body.classList.add('bg-light-theme');
                        localStorage.setItem('siteTheme','light');
                    }
                    updateIcon();
                });
            }
        })();
    </script>
