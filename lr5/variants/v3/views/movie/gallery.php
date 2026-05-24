<?php
$movies = $movies ?? [];
?>

<!-- Gallery title removed per design; movies show immediately -->

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
            <div class="movie-card" data-movie-id="<?= (int)$movie['id'] ?>">
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
                    <?php if (!empty($movie['age_limit']) && (int)$movie['age_limit'] > 0): ?>
                        <div class="age-badge"><?= (int)$movie['age_limit'] ?>+</div>
                    <?php endif; ?>
                    <h3 class="movie-title"><?= htmlspecialchars($movie['title']) ?></h3>
                    <div class="movie-rating">
                        <?php $rating = isset($movie['rating']) ? (float)$movie['rating'] : 0; ?>
                        <span class="rating-value"><?= $rating > 0 ? number_format($rating,1) : '—' ?></span>
                        <span class="rating-stars">
                            <?php for ($i=1;$i<=5;$i++): ?>
                                <span class="star<?= $i <= round($rating/2) ? ' active' : '' ?>">★</span>
                            <?php endfor; ?>
                        </span>
                    </div>
                    <p class="movie-director">Режисер: <?= htmlspecialchars($movie['director']) ?></p>
                    <p class="movie-year"><?= (int)$movie['year'] ?> • <?= (int)$movie['duration_min'] ?> хв</p>
                    <p class="movie-genre"><?= htmlspecialchars($movie['genre']) ?></p>
                    
                    <div class="movie-stats">
                        <span class="stat-item">💬 <?= (int)($movie['comments_count'] ?? 0) ?></span>
                        <span class="stat-item">👍 <?= (int)($movie['reactions_count'] ?? 0) ?></span>
                    </div>

                    <a href="#" class="btn btn-primary btn-open-modal">Детальна інформація</a>
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
    background: inherit;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: transform 0.3s, box-shadow 0.3s;
    color: inherit;
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
    color: inherit;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.movie-director {
    margin: 4px 0;
    font-size: 13px;
    color: inherit;
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
    background: rgba(255,255,255,0.04);
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

<!-- Modal placeholder -->
<div id="movieModal" class="modal" style="display:none;position:fixed;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.6);align-items:center;justify-content:center;z-index:9999;">
    <div class="modal-content card" style="padding:20px;max-width:900px;width:95%;max-height:90%;overflow:auto;position:relative;">
        <div style="position:absolute;right:12px;top:12px;display:flex;gap:8px;align-items:center;">
            <button id="modalClose" style="border:none;background:transparent;color:inherit;padding:6px 10px;border-radius:4px;cursor:pointer">✕</button>
        </div>
        <div id="modalBody">Завантаження...</div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('movieModal');
    const modalBody = document.getElementById('modalBody');
    const closeBtn = document.getElementById('modalClose');

    function openModal(html) {
        modalBody.innerHTML = html;
        // hide close button for compact movie-detail partial
        if (modalBody.querySelector('.movie-detail')) {
            closeBtn.style.display = 'none';
        } else {
            closeBtn.style.display = '';
        }
        // mark modal open so header auth can be hidden
        document.body.classList.add('modal-open');
        modal.style.display = 'flex';
    }

    function closeModal() {
        modal.style.display = 'none';
        modalBody.innerHTML = '';
        document.body.classList.remove('modal-open');
    }

    document.querySelectorAll('.btn-open-modal').forEach(function(btn){
        btn.addEventListener('click', function(e){
            e.preventDefault();
            const card = e.target.closest('.movie-card');
            const id = card ? card.getAttribute('data-movie-id') : null;
            if (!id) return;
            fetch('index.php?route=movie/api_detail&id=' + encodeURIComponent(id))
                .then(r => r.text())
                .then(html => openModal(html))
                .catch(() => openModal('<p>Не вдалося завантажити деталі.</p>'));
        });
    });

    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', function(e){ if (e.target === modal) closeModal(); });
});
</script>
