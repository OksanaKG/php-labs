<?php
$tickets = $tickets ?? [];
$total = $total ?? 0;
$screening = $screening ?? [];
?>
<h1>Чек покупки</h1>
<div class="receipt-card" style="max-width:700px;margin:0 auto;padding:20px;border-radius:8px;">
    <?php $poster = $screening['poster_image'] ?? ($tickets[0]['poster_image'] ?? ''); ?>
    <div style="display:flex;gap:20px;margin-bottom:20px;">
        <div style="flex:0 0 120px;">
            <?php if (!empty($poster)): ?>
                <img src="<?= htmlspecialchars($poster) ?>" alt="poster" style="width:100%;border-radius:6px;object-fit:cover;height:180px;">
            <?php else: ?>
                <div style="width:100%;height:180px;border-radius:6px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);display:flex;align-items:center;justify-content:center;color:#fff;font-size:36px;">🎬</div>
            <?php endif; ?>
        </div>
        <div style="flex:1;">
            <h2 style="margin-top:0;"><?= htmlspecialchars($screening['title'] ?? ($tickets[0]['title'] ?? '')) ?></h2>
            <p><strong>Сеанс:</strong> <?= htmlspecialchars($screening['screening_datetime'] ?? ($tickets[0]['screening_datetime'] ?? '')) ?></p>
        </div>
    </div>
    
    <h3>Квитки:</h3>
    <ul style="margin:10px 0;">
        <?php foreach ($tickets as $t): ?>
            <li style="margin:6px 0;">Ряд <?= (int)$t['row_num'] ?>, місце <?= (int)$t['seat_num'] ?> — <?= htmlspecialchars($t['ticket_number']) ?> — ₴<?= number_format($t['price'], 2) ?></li>
        <?php endforeach; ?>
    </ul>
    
    <p style="font-weight:700;font-size:18px;margin-top:16px;border-top:1px solid rgba(255,255,255,0.1);padding-top:16px;">Загалом: ₴<?= number_format($total, 2) ?></p>
    
    <div style="margin-top:20px;display:flex;gap:10px;">
        <a href="index.php?route=movie/my_tickets" class="btn">Мої квитки</a>
        <a href="index.php?route=movie/list" class="btn btn--secondary">До фільмів</a>
    </div>
</div>
