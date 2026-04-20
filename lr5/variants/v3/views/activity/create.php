<?php
$errors = $errors ?? [];
$old = $old ?? [];
?>

<h1>Додати активність кінотеатру</h1>

<div class="form-container">
    <form method="POST" action="index.php?route=activity/create">
        <div class="form-group">
            <label for="title">Назва активності: <span class="required">*</span></label>
            <input type="text" id="title" name="title" 
                   value="<?= htmlspecialchars($old['title'] ?? '') ?>"
                   required class="form-control">
            <?php if (isset($errors['title'])): ?>
                <span class="error"><?= htmlspecialchars($errors['title']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="description">Опис:</label>
            <textarea id="description" name="description" rows="5" class="form-control"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label for="activity_type">Тип активності:</label>
            <select id="activity_type" name="activity_type" class="form-control">
                <option value="charity" <?= ($old['activity_type'] ?? '') === 'charity' ? 'selected' : '' ?>>❤️ Благодійна</option>
                <option value="kids" <?= ($old['activity_type'] ?? '') === 'kids' ? 'selected' : '' ?>>🎈 Дитяча</option>
                <option value="special" <?= ($old['activity_type'] ?? '') === 'special' ? 'selected' : '' ?>>🎪 Спеціальна</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Додати активність</button>
            <a href="index.php?route=activity/list" class="btn">Скасувати</a>
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

.required {
    color: #dc3545;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    font-family: inherit;
    box-sizing: border-box;
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
