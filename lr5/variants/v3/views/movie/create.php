<?php
$errors = $errors ?? [];
$old = $old ?? [];
?>

<h1>Додати фільм</h1>

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

<form method="POST" action="index.php?route=movie/create" class="form">
    <div class="form__group <?= isset($errors['title']) ? 'form__group--error' : '' ?>">
        <label for="m_title" class="form__label">Назва фільму <span class="required">*</span></label>
        <input type="text" id="m_title" name="title" class="form__input"
               value="<?= htmlspecialchars($old['title'] ?? '') ?>"
               placeholder="The Shawshank Redemption">
        <?php if (isset($errors['title'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['title']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__group <?= isset($errors['director']) ? 'form__group--error' : '' ?>">
        <label for="m_director" class="form__label">Режисер <span class="required">*</span></label>
        <input type="text" id="m_director" name="director" class="form__input"
               value="<?= htmlspecialchars($old['director'] ?? '') ?>"
               placeholder="Frank Darabont">
        <?php if (isset($errors['director'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['director']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <div class="form__group">
            <label for="m_genre" class="form__label">Жанр</label>
            <input type="text" id="m_genre" name="genre" class="form__input"
                   value="<?= htmlspecialchars($old['genre'] ?? '') ?>"
                   placeholder="Drama, Action, Sci-Fi...">
        </div>

        <div class="form__group <?= isset($errors['year']) ? 'form__group--error' : '' ?>">
            <label for="m_year" class="form__label">Рік виходу</label>
            <input type="number" id="m_year" name="year" class="form__input" min="1888" max="<?= date('Y') + 1 ?>"
                   value="<?= htmlspecialchars($old['year'] ?? '') ?>"
                   placeholder="1994">
            <?php if (isset($errors['year'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['year']) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="form__group <?= isset($errors['duration_min']) ? 'form__group--error' : '' ?>">
        <label for="m_duration" class="form__label">Тривалість (хвилини)</label>
        <input type="number" id="m_duration" name="duration_min" class="form__input" min="1"
               value="<?= htmlspecialchars($old['duration_min'] ?? '') ?>"
               placeholder="142">
        <?php if (isset($errors['duration_min'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['duration_min']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__group">
        <label for="m_description" class="form__label">Опис фільму</label>
        <textarea id="m_description" name="description" class="form__input" rows="4"
                  placeholder="Коротко опишіть сюжет фільму..."><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
    </div>

    <div class="form__actions">
        <button type="submit" class="btn">Додати</button>
        <a href="index.php?route=movie/list" class="btn btn--secondary">Скасувати</a>
    </div>
</form>
