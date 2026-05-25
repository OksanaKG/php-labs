<?php
$totals = $totals ?? ['total_revenue' => 0, 'tickets_sold' => 0];
$popular = $popular ?? [];
?>
<h1>Адмін-панель</h1>
<div class="admin-dashboard">
    <div style="display:flex;gap:20px;align-items:center;margin-bottom:20px;">
        <div class="card" style="padding:15px;border-radius:8px;">
            <h3>Загальний дохід</h3>
            <p style="font-size:24px;font-weight:700;">₴<?= number_format($totals['total_revenue'] ?? 0, 2) ?></p>
        </div>
        <div class="card" style="padding:15px;border-radius:8px;">
            <h3>Продано квитків</h3>
            <p style="font-size:24px;font-weight:700;"><?= (int)($totals['tickets_sold'] ?? 0) ?></p>
        </div>
        <div class="card" style="padding:15px;border-radius:8px;">
            <h3>Дохід від товарів</h3>
            <p style="font-size:20px;font-weight:700;">₴<?= number_format($totals['product_revenue'] ?? 0, 2) ?></p>
        </div>
        <div class="card" style="padding:15px;border-radius:8px;">
            <h3>Продано товарів</h3>
            <p style="font-size:20px;font-weight:700;"><?= (int)($totals['product_sold'] ?? 0) ?></p>
        </div>
        <div class="card" style="padding:15px;border-radius:8px;">
            <h3>Разом (вкл. товари)</h3>
            <p style="font-size:20px;font-weight:700;">₴<?= number_format($totals['combined_revenue'] ?? ($totals['total_revenue'] ?? 0), 2) ?></p>
        </div>
    </div>

    <h2>Популярні фільми (продано квитків)</h2>
    <table class="table">
        <thead><tr><th>Фільм</th><th>Продано</th></tr></thead>
        <tbody>
            <?php foreach ($popular as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['title']) ?></td>
                    <td><?= (int)$p['sold'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
