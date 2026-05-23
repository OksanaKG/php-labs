<?php
$movie = $movie ?? [];
$screenings = $screenings ?? [];
$comments = $comments ?? [];
 
?>
<div class="movie-detail">
    <div style="display:flex;gap:20px;align-items:flex-start;">
        <div style="flex:0 0 260px;">
            <?php if (!empty($movie['poster_image'])): ?>
                <img src="<?= htmlspecialchars($movie['poster_image']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>" style="width:100%;border-radius:6px;object-fit:cover;">
            <?php else: ?>
                <div style="width:100%;border-radius:6px;aspect-ratio:2/3;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);display:flex;align-items:center;justify-content:center;color:#fff;font-size:36px;">🎬</div>
            <?php endif; ?>
        </div>
        <div style="flex:1;">
            <h2><?= htmlspecialchars($movie['title']) ?> <?php if (!empty($movie['age_limit'])): ?><small style="color:#777;font-size:14px;"> <?= (int)$movie['age_limit'] ?>+</small><?php endif; ?></h2>
            <p style="margin:6px 0;color:#555;"><strong>Режисер:</strong> <?= htmlspecialchars($movie['director']) ?> • <strong>Рік:</strong> <?= (int)$movie['year'] ?> • <strong>Тривалість:</strong> <?= (int)$movie['duration_min'] ?> хв</p>
            <p style="color:#333;"><?= nl2br(htmlspecialchars($movie['description'] ?? '')) ?></p>

            <div style="margin-top:12px;">
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === 1): ?>
                    <a href="index.php?route=movie/create_screening&movie_id=<?= (int)$movie['id'] ?>" class="btn" style="margin-right:10px;">Додати сеанс</a>
                    <a href="index.php?route=movie/edit&id=<?= (int)$movie['id'] ?>" class="btn">Редагувати</a>
                <?php endif; ?>
            </div>

            <h3 style="margin-top:18px;">Сеанси</h3>
            <?php if (empty($screenings)): ?>
                <p class="text-muted">Поки що немає запланованих сеансів.</p>
            <?php else: ?>
                <ul style="list-style:none;padding:0;margin:0;">
                    <?php foreach ($screenings as $s): ?>
                        <li style="margin:8px 0;padding:8px;border:1px solid #eee;border-radius:6px;display:flex;justify-content:space-between;align-items:center;">
                            <span><?= htmlspecialchars($s['hall_name']) ?> — <?= htmlspecialchars($s['screening_datetime']) ?></span>
                            <span>
                                <a href="index.php?route=movie/buy_ticket&screening_id=<?= (int)$s['id'] ?>" class="btn btn-primary">Купити</a>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <h3 style="margin-top:18px;">Коментарі (<?= count($comments) ?>)</h3>
            <?php if (empty($comments)): ?>
                <p class="text-muted">Коментарів ще немає. <a href="index.php?route=movie/detail&id=<?= (int)$movie['id'] ?>">Залишити перший коментар</a></p>
            <?php else: ?>
                <div style="margin-top:10px;">
                    <?php foreach ($comments as $c): ?>
                        <div style="padding:8px;border:1px solid #eee;border-radius:6px;margin-bottom:8px;">
                            <strong><?= htmlspecialchars($c['first_name'] . ' ' . $c['last_name']) ?></strong>
                            <span style="color:#888;margin-left:8px;font-size:12px;"><?= date('d.m.Y H:i', strtotime($c['created_at'])) ?></span>
                            <div style="margin-top:6px;"><?= nl2br(htmlspecialchars($c['comment'])) ?></div>
                        </div>
                    <?php endforeach; ?>
                    <p><a href="index.php?route=movie/detail&id=<?= (int)$movie['id'] ?>">Переглянути всі та залишити коментар</a></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
