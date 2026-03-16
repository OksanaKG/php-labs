<?php
$getParams = $getParams ?? [];
$postParams = $postParams ?? [];
$method = $method ?? 'GET';
?>

<h1>Перегляд параметрів запиту</h1>

<div class="reqview-grid">
    <div class="reqview-section">
        <h2>POST-форма</h2>
        <p>Надішліть POST-запит з довільними даними про фільм:</p>
        <form method="POST" action="index.php?route=reqview/showrequest&cinema=true" class="form">
            <div class="form__group">
                <label for="post_movie" class="form__label">Назва фільму</label>
                <input type="text" id="post_movie" name="movie" class="form__input" placeholder="Аватар">
            </div>
            <div class="form__group">
                <label for="post_genre" class="form__label">Жанр</label>
                <input type="text" id="post_genre" name="genre" class="form__input" placeholder="Фантастика">
            </div>
            <div class="form__group">
                <label for="post_rating" class="form__label">Рейтинг (1-10)</label>
                <input type="number" id="post_rating" name="rating" class="form__input" min="1" max="10" placeholder="8">
            </div>
            <button type="submit" class="btn">Надіслати POST</button>
        </form>

        <h3>GET-параметри в URL</h3>
        <p>Додайте параметри до URL, наприклад:</p>
        <code class="code-block">index.php?route=reqview/showrequest&movie=Avatar&time=19:00</code>
    </div>

    <div class="reqview-section">
        <h2>Результат</h2>
        <p><strong>Метод запиту:</strong> <code><?= htmlspecialchars($method) ?></code></p>

        <h3>GET-параметри</h3>
        <?php if (empty($getParams)): ?>
            <p class="text-muted">GET-параметрів немає.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr><th>Параметр</th><th>Значення</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($getParams as $key => $value): ?>
                        <tr>
                            <td><code><?= htmlspecialchars($key) ?></code></td>
                            <td><?= htmlspecialchars(is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <h3>POST-параметри</h3>
        <?php if (empty($postParams)): ?>
            <p class="text-muted">POST-параметрів немає.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr><th>Параметр</th><th>Значення</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($postParams as $key => $value): ?>
                        <tr>
                            <td><code><?= htmlspecialchars($key) ?></code></td>
                            <td><?= htmlspecialchars(is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
