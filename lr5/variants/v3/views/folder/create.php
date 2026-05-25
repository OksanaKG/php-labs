<h1>Товари</h1>
<?php $products = $products ?? []; ?>
<?php if (!empty($_SESSION['user_id']) && $_SESSION['user_id'] === 1): ?>
    <h3>Додати товар (адмін)</h3>
    <form method="POST" action="index.php?route=folder/upload_product" enctype="multipart/form-data" style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
        <input type="text" name="name" placeholder="Назва" required style="padding:8px;border-radius:6px;border:1px solid #ccc;">
        <input type="text" name="price" placeholder="Ціна" required style="padding:8px;border-radius:6px;border:1px solid #ccc;width:100px;">
        <input type="text" name="description" placeholder="Опис" style="padding:8px;border-radius:6px;border:1px solid #ccc;">
        <input type="file" name="product_image" accept="image/*">
        <button class="btn" type="submit">Додати товар</button>
    </form>
<?php endif; ?>


<div class="products" style="display:flex;gap:16px;flex-wrap:wrap;margin-top:12px;">
    <?php if (empty($products)): ?>
        <div class="card" style="padding:18px;border-radius:8px;min-width:220px;">
            <h3>Товари відсутні</h3>
            <p class="text-muted">Поки що товарів немає. Ви можете додати новий товар у розділі "Додати товар" (адмін).</p>
            <?php if (!empty($_SESSION['user_id']) && $_SESSION['user_id'] === 1): ?>
                <a href="#add" class="btn">Додати перший товар</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <?php foreach ($products as $p): ?>
            <div class="card product-card" style="padding:12px;border-radius:8px;min-width:180px;cursor:pointer;" data-id="<?= (int)$p['id'] ?>">
                <?php if (!empty($p['image'])): ?>
                    <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" style="width:100%;height:120px;object-fit:cover;border-radius:6px;margin-bottom:8px;">
                <?php endif; ?>
                <h3 style="margin:0;"><?= htmlspecialchars($p['name']) ?></h3>
                <div style="color:inherit;opacity:0.9;"><?= htmlspecialchars($p['description']) ?></div>
                <div style="font-weight:700;margin-top:8px;">₴<?= number_format($p['price'],2) ?></div>
                <a href="index.php?route=folder/buy_product&id=<?= (int)$p['id'] ?>" class="btn" style="margin-top:8px;display:inline-block;">Купити</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    // make whole card clickable
    document.querySelectorAll('.product-card').forEach(function(card){
        card.addEventListener('click', function(e){
            if (e.target.tagName.toLowerCase() === 'a' || e.target.tagName.toLowerCase() === 'button' || e.target.tagName.toLowerCase() === 'input') return;
            const id = card.getAttribute('data-id');
            if (id) window.location.href = 'index.php?route=folder/buy_product&id=' + id;
        });
    });
</script>
