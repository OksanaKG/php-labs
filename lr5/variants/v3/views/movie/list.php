<?php
$movies = $movies ?? [];
$currentSort = $currentSort ?? 'id';
$currentOrder = $currentOrder ?? 'asc';

function sortLink($column, $currentSort, $currentOrder) {
    $order = ($currentSort === $column && $currentOrder === 'asc') ? 'desc' : 'asc';
    return "index.php?route=movie/list&sort={$column}&order={$order}";
}
?>

<h1>Фільми</h1>
<p>Колекція фільмів кінотеатру. CRUD через PDO (prepared statements).</p>

    <div class="form__actions" style="margin-bottom: 20px;display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
    <a href="index.php?route=movie/gallery" class="btn">📸 Галерея фільмів</a>
    <a href="index.php?route=activity/list" class="btn">♥️ Активності</a>
    <?php if (!empty($genres)): ?>
        <label style="margin-left:8px;">Жанр:</label>
        <select id="genreFilter" class="form__select" style="min-width:160px;">
            <option value="">Усі жанри</option>
            <?php foreach ($genres as $g): ?>
                <option value="<?= htmlspecialchars($g) ?>" <?= ($g === ($currentGenre ?? '')) ? 'selected' : '' ?>><?= htmlspecialchars($g) ?></option>
            <?php endforeach; ?>
        </select>
    <?php endif; ?>
    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === 1): ?>
        <a href="index.php?route=movie/create" class="btn">Додати фільм</a>
    <?php endif; ?>
</div>

<script>
document.getElementById('genreFilter')?.addEventListener('change', function(){
    const g = this.value;
    const params = new URLSearchParams(window.location.search);
    if (g) params.set('genre', g); else params.delete('genre');
    // keep sort/order if present
    window.location.href = 'index.php?route=movie/list&' + params.toString();
});
</script>

<?php if (empty($movies)): ?>
    <p class="text-muted">Фільмів ще немає.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th><a href="<?= sortLink('id', $currentSort, $currentOrder) ?>" class="sort-link">ID</a></th>
                <th><a href="<?= sortLink('title', $currentSort, $currentOrder) ?>" class="sort-link">Назва</a></th>
                <th><a href="<?= sortLink('director', $currentSort, $currentOrder) ?>" class="sort-link">Режисер</a></th>
                <th><a href="<?= sortLink('genre', $currentSort, $currentOrder) ?>" class="sort-link">Жанр</a></th>
                <th><a href="<?= sortLink('year', $currentSort, $currentOrder) ?>" class="sort-link">Рік</a></th>
                <th><a href="<?= sortLink('duration_min', $currentSort, $currentOrder) ?>" class="sort-link">Тривалість (хв)</a></th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movies as $m): ?>
                <tr>
                    <td><?= (int)$m['id'] ?></td>
                    <td><?= htmlspecialchars($m['title']) ?></td>
                    <td><?= htmlspecialchars($m['director']) ?></td>
                    <td><?= htmlspecialchars($m['genre']) ?></td>
                    <td><?= (int)$m['year'] ?></td>
                    <td><?= (int)$m['duration_min'] ?></td>
                    <td class="table__actions">
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === 1): ?>
                            <a href="index.php?route=movie/edit&id=<?= (int)$m['id'] ?>" class="btn btn--small">Редагувати</a>
                            <form method="POST" action="index.php?route=movie/delete" style="display:inline"
                                  onsubmit="return confirm('Видалити фільм?')">
                                <input type="hidden" name="id" value="<?= (int)$m['id'] ?>">
                                <button type="submit" class="btn btn--small btn--danger">Видалити</button>
                            </form>
                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
