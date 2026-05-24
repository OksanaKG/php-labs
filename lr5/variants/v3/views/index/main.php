<div class="page-home">
    <h1>Кінотеатр</h1>
    <p class="text-muted">Колекція фільмів — оберіть фільм для деталей та купівлі квитків.</p>

    <!-- На головній показуємо тільки галерею фільмів -->
    <?php if (!empty($movies)): ?>
        <h2 style="margin-top:30px">Колекція фільмів</h2>
        <div class="form__actions" style="margin-bottom:12px;display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
            <button type="button" class="btn" data-sort="title" data-order="asc">За назвою</button>
            <button type="button" class="btn" data-sort="year" data-order="desc">За роком</button>
            <button type="button" class="btn" data-sort="duration_min" data-order="desc">За тривалістю</button>
            <div style="position:relative;">
                <button id="genreToggle" type="button" class="btn">За жанром ▾</button>
                <?php if (!empty($genres)): ?>
                    <div id="genreDropdown" style="display:none;position:absolute;left:0;top:36px;background:inherit;border:1px solid rgba(0,0,0,0.08);padding:8px;border-radius:6px;z-index:50;min-width:200px;">
                        <select id="genreFilter" class="form__select" style="width:100%;">
                            <option value="">Всі жанри</option>
                            <?php foreach ($genres as $g): ?>
                                <option value="<?= htmlspecialchars($g) ?>" <?= (!empty($currentGenre) && $currentGenre === $g) ? 'selected' : '' ?>><?= htmlspecialchars($g) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php require __DIR__ . '/../movie/gallery.php'; ?>
        <script>
            (function(){
                // toggle dropdown
                const toggle = document.getElementById('genreToggle');
                const dropdown = document.getElementById('genreDropdown');
                if (toggle && dropdown) {
                    toggle.addEventListener('click', function(){ dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block'; });
                    document.addEventListener('click', function(e){ if (!toggle.contains(e.target) && !dropdown.contains(e.target)) dropdown.style.display = 'none'; });
                }
                // sort buttons
                document.querySelectorAll('.form__actions button[data-sort]').forEach(function(btn){
                    btn.addEventListener('click', function(){
                        const params = new URLSearchParams(window.location.search);
                        params.set('sort', btn.dataset.sort);
                        params.set('order', btn.dataset.order);
                        const g = document.getElementById('genreFilter');
                        if (g) params.set('genre', g.value);
                        params.delete('route');
                        window.location.search = params.toString();
                    });
                });
                const g = document.getElementById('genreFilter');
                if (g) g.addEventListener('change', function(){
                    const params = new URLSearchParams(window.location.search);
                    params.set('genre', this.value);
                    params.delete('route');
                    window.location.search = params.toString();
                });
            })();
        </script>
    <?php else: ?>
        <p class="text-muted">Поки що фільмів немає.</p>
    <?php endif; ?>
</div>
