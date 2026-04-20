<?php
$movie = $movie ?? [];
$halls = $halls ?? [];
$errors = $errors ?? [];
$old = $old ?? [];
?>

<h1>Додати сеанс для фільму: <?= htmlspecialchars($movie['title'] ?? '') ?></h1>

<div class="form-container">
    <form method="POST" action="index.php?route=movie/create_screening&movie_id=<?= (int)$movie['id'] ?>">
        <div class="form-group">
            <label for="screening_datetime">Дата і час сеансу:</label>
            <input type="datetime-local" id="screening_datetime" name="screening_datetime" 
                   value="<?= htmlspecialchars($old['screening_datetime'] ?? '') ?>"
                   required class="form-control">
            <?php if (isset($errors['screening_datetime'])): ?>
                <span class="error"><?= htmlspecialchars($errors['screening_datetime']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="hall_id">Зала:</label>
            <select id="hall_id" name="hall_id" required class="form-control">
                <option value="">-- Оберіть залу --</option>
                <?php foreach ($halls as $hall): ?>
                    <option value="<?= (int)$hall['id'] ?>" 
                            <?= isset($old['hall_id']) && (int)$old['hall_id'] === (int)$hall['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($hall['name']) ?> (<?= (int)$hall['rows'] ?> рядів × <?= (int)$hall['seats_per_row'] ?> місць)
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['hall_id'])): ?>
                <span class="error"><?= htmlspecialchars($errors['hall_id']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="price_per_ticket">Ціна за квиток (₴):</label>
            <input type="number" id="price_per_ticket" name="price_per_ticket" 
                   value="<?= htmlspecialchars($old['price_per_ticket'] ?? '') ?>"
                   step="0.01" min="0" required class="form-control">
            <?php if (isset($errors['price_per_ticket'])): ?>
                <span class="error"><?= htmlspecialchars($errors['price_per_ticket']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Додати сеанс</button>
            <a href="index.php?route=movie/detail&id=<?= (int)$movie['id'] ?>" class="btn">Скасувати</a>
        </div>
    </form>
</div>

<style>
.form-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 8px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    font-family: inherit;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
}

.error {
    display: block;
    color: #dc3545;
    font-size: 12px;
    margin-top: 5px;
}

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.btn-primary {
    background: #667eea;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.btn-primary:hover {
    background: #5568d3;
}

.btn {
    padding: 10px 20px;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
    border: 1px solid #ddd;
    background: white;
    cursor: pointer;
    font-size: 14px;
}

.btn:hover {
    background: #f0f0f0;
}
</style>
