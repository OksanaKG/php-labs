<?php
$product = $product ?? [];
?>
<h1>Купівля товару</h1>
<div style="display:flex;gap:18px;align-items:flex-start;">
    <div style="flex:0 0 180px;">
        <?php if (!empty($product['image'])): ?>
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width:100%;border-radius:8px;object-fit:cover;">
        <?php else: ?>
            <div style="width:100%;height:180px;border-radius:8px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);display:flex;align-items:center;justify-content:center;color:#fff;font-size:40px;">🛍️</div>
        <?php endif; ?>
    </div>
    <div style="flex:1;">
        <h2><?= htmlspecialchars($product['name'] ?? '') ?></h2>
        <p style="font-size:18px;font-weight:600;color:#28a745;">₴<?= number_format($product['price'] ?? 0, 2) ?></p>
        <p><?= nl2br(htmlspecialchars($product['description'] ?? '')) ?></p>
        <form method="POST" action="index.php?route=folder/purchase_product">
            <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
            <div style="margin:8px 0;">
                <label>Ім'я покупця:<br><input type="text" name="name" value="" required style="padding:8px;width:100%;border-radius:6px;border:1px solid rgba(0,0,0,0.08);"></label>
            </div>
            <div style="display:flex;gap:8px;">
                <button class="btn btn-success" type="submit">Купити</button>
                <a class="btn" href="index.php?route=folder/create">Скасувати</a>
            </div>
        </form>
    </div>
</div>
