<?php
$movie = $movie ?? [];
$errors = $errors ?? [];
?>

<h1>Редагувати фільм #<?= (int)($movie['id'] ?? 0) ?></h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert--error">
        <strong>Помилки:</strong>
        <ul>
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="index.php?route=movie/edit&id=<?= (int)($movie['id'] ?? 0) ?>" class="form" enctype="multipart/form-data">
    <div class="form__group <?= isset($errors['title']) ? 'form__group--error' : '' ?>">
        <label for="m_title" class="form__label">Назва фільму <span class="required">*</span></label>
        <input type="text" id="m_title" name="title" class="form__input"
               value="<?= htmlspecialchars($movie['title'] ?? '') ?>">
        <?php if (isset($errors['title'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['title']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__group <?= isset($errors['director']) ? 'form__group--error' : '' ?>">
        <label for="m_director" class="form__label">Режисер <span class="required">*</span></label>
        <input type="text" id="m_director" name="director" class="form__input"
               value="<?= htmlspecialchars($movie['director'] ?? '') ?>">
        <?php if (isset($errors['director'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['director']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <div class="form__group">
            <label for="m_genre" class="form__label">Жанр</label>
            <input type="text" id="m_genre" name="genre" class="form__input"
                   value="<?= htmlspecialchars($movie['genre'] ?? '') ?>">
        </div>

        <div class="form__group <?= isset($errors['year']) ? 'form__group--error' : '' ?>">
            <label for="m_year" class="form__label">Рік виходу</label>
            <input type="number" id="m_year" name="year" class="form__input" min="1888" max="<?= date('Y') + 1 ?>"
                   value="<?= htmlspecialchars($movie['year'] ?? '') ?>">
            <?php if (isset($errors['year'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['year']) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="form__group <?= isset($errors['duration_min']) ? 'form__group--error' : '' ?>">
        <label for="m_duration" class="form__label">Тривалість (хвилини)</label>
        <input type="number" id="m_duration" name="duration_min" class="form__input" min="1"
               value="<?= htmlspecialchars($movie['duration_min'] ?? '') ?>">
        <?php if (isset($errors['duration_min'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['duration_min']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__group">
        <label for="m_description" class="form__label">Опис фільму</label>
        <textarea id="m_description" name="description" class="form__input" rows="4"><?= htmlspecialchars($movie['description'] ?? '') ?></textarea>
    </div>

    <div class="form__group">
        <label for="m_age" class="form__label">Вікове обмеження</label>
        <select id="m_age" name="age_limit" class="form__input">
            <option value="0" <?= (isset($movie['age_limit']) && $movie['age_limit'] == 0) ? 'selected' : '' ?>>Без обмежень</option>
            <option value="6" <?= (isset($movie['age_limit']) && $movie['age_limit'] == 6) ? 'selected' : '' ?>>6+</option>
            <option value="12" <?= (isset($movie['age_limit']) && $movie['age_limit'] == 12) ? 'selected' : '' ?>>12+</option>
            <option value="16" <?= (isset($movie['age_limit']) && $movie['age_limit'] == 16) ? 'selected' : '' ?>>16+</option>
            <option value="18" <?= (isset($movie['age_limit']) && $movie['age_limit'] == 18) ? 'selected' : '' ?>>18+</option>
        </select>
    </div>

    <div class="form__group">
        <label for="m_poster" class="form__label">Обкладинка (JPEG/PNG)</label>
        <input type="file" id="m_poster" name="poster_image" accept="image/*" class="form__input">
        <?php if (!empty($movie['poster_image'])): ?>
            <div style="margin-top:10px"><img src="<?= htmlspecialchars($movie['poster_image']) ?>" alt="poster" style="max-width:120px;border-radius:4px;border:1px solid #ddd"></div>
        <?php endif; ?>
    </div>

    <div class="form__actions">
        <button type="submit" class="btn">Зберегти</button>
        <a href="index.php?route=movie/list" class="btn btn--secondary">Скасувати</a>
    </div>
</form>
