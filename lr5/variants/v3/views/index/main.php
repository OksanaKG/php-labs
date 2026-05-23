<div class="page-home">
    <h1>Кінотеатр</h1>
    <p class="text-muted">Колекція фільмів — оберіть фільм для деталей та купівлі квитків.</p>

    <!-- На головній показуємо тільки галерею фільмів -->
    <?php if (!empty($movies)): ?>
        <h2 style="margin-top:30px">Колекція фільмів</h2>
        <?php require __DIR__ . '/../movie/gallery.php'; ?>
    <?php else: ?>
        <p class="text-muted">Поки що фільмів немає.</p>
    <?php endif; ?>
</div>
