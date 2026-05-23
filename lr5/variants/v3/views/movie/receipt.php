<?php
$tickets = $tickets ?? [];
$total = $total ?? 0;
$screening = $screening ?? [];
?>
<h1>Чек покупки</h1>
<div style="max-width:700px;background:#fff;padding:20px;border-radius:8px;border:1px solid #eee;">
    <?php $poster = $screening['poster_image'] ?? ($tickets[0]['poster_image'] ?? ''); ?>
    <div style="display:flex;gap:12px;align-items:center;">
        <?php if (!empty($poster)): ?>
            <div style="width:100px;flex:0 0 100px;"><img src="<?= htmlspecialchars($poster) ?>" alt="poster" style="width:100%;border-radius:6px;object-fit:cover"></div>
        <?php else: ?>
            <div style="width:100px;flex:0 0 100px;border-radius:6px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);display:flex;align-items:center;justify-content:center;color:#fff;font-size:24px;">🎬</div>
        <?php endif; ?>
        <div style="flex:1;">
            <p><strong>Фільм:</strong> <?= htmlspecialchars($screening['title'] ?? ($tickets[0]['title'] ?? '')) ?></p>
            <p><strong>Сеанс:</strong> <?= htmlspecialchars($screening['screening_datetime'] ?? ($tickets[0]['screening_datetime'] ?? '')) ?></p>
        </div>
    </div>
    <p style="margin-top:12px"><strong>Квитки:</strong></p>
    <ul>
        <?php foreach ($tickets as $t): ?>
            <li>Ряд <?= (int)$t['row_num'] ?>, місце <?= (int)$t['seat_num'] ?> — <?= htmlspecialchars($t['ticket_number']) ?> — ₴<?= number_format($t['price'], 2) ?></li>
        <?php endforeach; ?>
    </ul>
    <p style="font-weight:700">Загалом: ₴<?= number_format($total, 2) ?></p>
    <div style="margin-top:12px;display:flex;gap:10px;">
        <a href="index.php?route=movie/my_tickets" class="btn">Мої квитки</a>
        <a href="index.php?route=movie/detail&id=<?= (int)($screening['movie_id'] ?? ($tickets[0]['movie_id'] ?? 0)) ?>" class="btn btn--secondary">Повернутися до фільму</a>
    </div>
</div>
