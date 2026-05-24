<?php
$tickets = $tickets ?? [];
?>
<h1>Мої квитки</h1>
<?php if (empty($tickets)): ?>
    <p class="text-muted">У вас ще немає квитків.</p>
<?php else: ?>
    <div class="tickets-list">
        <?php foreach ($tickets as $t): ?>
            <div class="ticket-card card" style="display:flex;gap:12px;margin-bottom:12px;">
                <div style="flex:0 0 100px;">
                    <?php if (!empty($t['poster_image'])): ?>
                        <img src="<?= htmlspecialchars($t['poster_image']) ?>" alt="poster" style="width:100%;height:140px;object-fit:cover;border-radius:6px;">
                    <?php else: ?>
                        <div style="width:100%;height:140px;border-radius:6px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);display:flex;align-items:center;justify-content:center;color:#fff;font-size:28px;">🎬</div>
                    <?php endif; ?>
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:8px;">
                    <div>
                        <div style="font-weight:700;font-size:16px;"><?= htmlspecialchars($t['title']) ?></div>
                        <div style="color:inherit;opacity:0.75;font-size:12px;"><?= htmlspecialchars($t['screening_datetime']) ?></div>
                    </div>
                    <div style="color:inherit;opacity:0.85;font-size:13px;">Місце: Ряд <?= (int)$t['row_num'] ?>, місце <?= (int)$t['seat_num'] ?></div>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:auto;">
                        <div>
                            <div style="font-weight:700;font-size:18px;">₴<?= number_format($t['price'],2) ?></div>
                            <div style="color:inherit;opacity:0.75;font-size:12px;"><?= htmlspecialchars($t['booking_status']) ?></div>
                        </div>
                        <div>
                            <?php if ($t['booking_status'] !== 'cancelled'): ?>
                                <form method="POST" action="index.php?route=movie/cancel_ticket" onsubmit="return confirm('Ви впевнені, що хочете скасувати квиток?');">
                                    <input type="hidden" name="ticket_id" value="<?= (int)$t['id'] ?>">
                                    <button class="btn btn--danger" style="padding:6px 12px;font-size:12px;">Скасувати</button>
                                </form>
                            <?php else: ?>
                                <div style="color:inherit;opacity:0.5">—</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
