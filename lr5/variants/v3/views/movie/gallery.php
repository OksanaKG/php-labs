<?php
$movies = $movies ?? [];
?>

<h1>Галерея фільмів</h1>
<p>Виберіть фільм для перегляду детальної інформації, коментарів та голосувань.</p>

<div class="form__actions" style="margin-bottom: 20px">
    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === 1): ?>
        <a href="index.php?route=movie/create" class="btn">Додати фільм</a>
    <?php endif; ?>
</div>

<?php if (empty($movies)): ?>
    <p class="text-muted">Фільмів ще немає.</p>
<?php else: ?>
    <div class="movie-gallery">
        <?php foreach ($movies as $movie): ?>
            <div class="movie-card">
                <div class="movie-poster">
                    <?php if (!empty($movie['poster_image'])): ?>
                        <img src="<?= htmlspecialchars($movie['poster_image']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>">
                    <?php else: ?>
                        <div class="poster-placeholder">
                            <span class="icon">🎬</span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="movie-info">
                    <h3 class="movie-title"><?= htmlspecialchars($movie['title']) ?></h3>
                    <p class="movie-director">Режисер: <?= htmlspecialchars($movie['director']) ?></p>
                    <p class="movie-year"><?= (int)$movie['year'] ?> • <?= (int)$movie['duration_min'] ?> хв</p>
                    <p class="movie-genre"><?= htmlspecialchars($movie['genre']) ?></p>
                    
                    <div class="movie-stats">
                        <span class="stat-item">💬 <?= (int)($movie['comments_count'] ?? 0) ?></span>
                        <span class="stat-item">👍 <?= (int)($movie['reactions_count'] ?? 0) ?></span>
                    </div>

                    <a href="index.php?route=movie/detail&id=<?= (int)$movie['id'] ?>" class="btn btn-primary">Детальна інформація</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
.movie-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.movie-card {
    background: #f9f9f9;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.movie-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.2);
}

.movie-poster {
    width: 100%;
    height: 250px;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.movie-poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.poster-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.poster-placeholder .icon {
    font-size: 60px;
}

.movie-info {
    padding: 15px;
}

.movie-title {
    margin: 0 0 8px 0;
    font-size: 16px;
    color: #333;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.movie-director {
    margin: 4px 0;
    font-size: 13px;
    color: #666;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.movie-year,
.movie-genre {
    margin: 4px 0;
    font-size: 12px;
    color: #888;
}

.movie-stats {
    display: flex;
    gap: 10px;
    margin: 10px 0;
    font-size: 13px;
}

.stat-item {
    padding: 4px 8px;
    background: #e9ecef;
    border-radius: 4px;
}

.btn-primary {
    display: inline-block;
    width: 100%;
    padding: 8px;
    background: #667eea;
    color: white;
    text-align: center;
    border-radius: 4px;
    text-decoration: none;
    font-size: 13px;
    transition: background 0.3s;
    box-sizing: border-box;
}

.btn-primary:hover {
    background: #5568d3;
}
</style>
