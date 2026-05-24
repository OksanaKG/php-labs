<?php
$receipt = $receipt ?? [];
?>
<h1>Чек покупки</h1>
<div style="display:flex;gap:18px;align-items:flex-start;">
    <div style="flex:0 0 160px;">
        <?php if (!empty($receipt['product']['image'])): ?>
            <img src="<?= htmlspecialchars($receipt['product']['image']) ?>" alt="<?= htmlspecialchars($receipt['product']['name']) ?>" style="width:100%;border-radius:8px;object-fit:cover;">
        <?php else: ?>
            <div style="width:100%;height:160px;border-radius:8px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);display:flex;align-items:center;justify-content:center;color:#fff;font-size:32px;">🧾</div>
        <?php endif; ?>
    </div>
    <div style="flex:1;">
        <h2><?= htmlspecialchars($receipt['product']['name'] ?? '') ?></h2>
        <p>Покупець: <strong><?= htmlspecialchars($receipt['buyer'] ?? '') ?></strong></p>
        <p>Ціна: <strong>₴<?= number_format($receipt['price'] ?? 0, 2) ?></strong></p>
        <p>Час: <?= htmlspecialchars($receipt['created_at'] ?? '') ?></p>
        <div style="margin-top:12px;">
            <a class="btn" href="index.php?route=folder/create">До товарів</a>
        </div>
    </div>
</div>
