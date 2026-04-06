<div class="page-home">
    <h1>Кінотеатр</h1>
    <p class="page-home__subtitle">Варіант 3 &mdash; Лабораторна робота №5</p>
    <p class="text-muted">Колекція фільмів. Файлова гостьова книга, галерея фото фільмів, CRUD фільмів через PDO, авторизація.</p>

    <h2>Файли</h2>
    <div class="card-grid">
        <div class="card">
            <h3 class="card__title">Гостьова книга</h3>
            <p class="card__text">Залишайте відгуки про фільми. Коментарі зберігаються у текстовому файлі.</p>
            <a href="index.php?route=guestbook/index" class="btn btn--small">Відгуки</a>
        </div>

        <div class="card">
            <h3 class="card__title">Фото фільмів</h3>
            <p class="card__text">Завантажуйте фото з фільмів. Галерея кінематографічних шедеврів.</p>
            <a href="index.php?route=upload/index" class="btn btn--small">Галерея</a>
        </div>

        <div class="card">
            <h3 class="card__title">Каталоги глядачів</h3>
            <p class="card__text">Персональні папки для глядачів з колекціями відео, музики та фото.</p>
            <a href="index.php?route=folder/create" class="btn btn--small">Каталоги</a>
        </div>
    </div>

    <h2>База даних</h2>
    <div class="card-grid">
        <div class="card">
            <h3 class="card__title">Фільми (CRUD)</h3>
            <p class="card__text">Колекція фільмів з режисером, жанром, роком та тривалістю. PDO + SQLite.</p>
            <a href="index.php?route=movie/list" class="btn btn--small">До фільмів</a>
        </div>

        <div class="card">
            <h3 class="card__title">Акаунт глядача</h3>
            <p class="card__text">Реєстрація, вхід, профіль. Хешування паролів, сесійна авторизація.</p>
            <a href="index.php?route=auth/login" class="btn btn--small">Увійти</a>
        </div>

        <div class="card">
            <h3 class="card__title">Налаштування</h3>
            <p class="card__text">Колір фону (сесія) та привітання (cookie). Успадковано з ЛР4.</p>
            <a href="index.php?route=settings/color" class="btn btn--small">Налаштування</a>
        </div>
    </div>
</div>
