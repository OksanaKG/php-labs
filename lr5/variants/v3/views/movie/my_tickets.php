<?php
$tickets = $tickets ?? [];
?>
<h1>Мої квитки</h1>
<?php if (empty($tickets)): ?>
    <p class="text-muted">У вас ще немає квитків.</p>
<?php else: ?>
    <div class="tickets-list">
        <?php foreach ($tickets as $t): ?>
            <div class="ticket-card card" style="display:flex;gap:12px;align-items:center;margin-bottom:12px;">
                <div style="flex:0 0 84px;">
                    <?php if (!empty($t['poster_image'])): ?>
                        <img src="<?= htmlspecialchars($t['poster_image']) ?>" alt="poster" style="width:84px;height:120px;object-fit:cover;border-radius:6px;">
                    <?php else: ?>
                        <div style="width:84px;height:120px;border-radius:6px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);display:flex;align-items:center;justify-content:center;color:#fff;font-size:28px;">🎬</div>
                    <?php endif; ?>
                </div>
                <div style="flex:1;">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;">
                        <div>
                            <div style="font-weight:700;"><?= htmlspecialchars($t['title']) ?></div>
                            <div style="color:#999;font-size:13px;"><?= htmlspecialchars($t['screening_datetime']) ?></div>
                        </div>
                        <div style="text-align:right;">
                            <div style="font-weight:700;">₴<?= number_format($t['price'],2) ?></div>
                            <div style="color:#999;font-size:13px;"><?= htmlspecialchars($t['booking_status']) ?></div>
                        </div>
                    </div>
                    <div style="margin-top:8px;color:#333;">Місце: Ряд <?= (int)$t['row_num'] ?>, місце <?= (int)$t['seat_num'] ?></div>
                </div>
                <div style="flex:0 0 120px;"> 
                    <?php if ($t['booking_status'] !== 'cancelled'): ?>
                        <form method="POST" action="index.php?route=movie/cancel_ticket" onsubmit="return confirm('Ви впевнені, що хочете скасувати квиток?');">
                            <input type="hidden" name="ticket_id" value="<?= (int)$t['id'] ?>">
                            <button class="btn btn--danger">Скасувати</button>
                        </form>
                    <?php else: ?>
                        <div style="color:#777">—</div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
