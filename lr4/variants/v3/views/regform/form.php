<?php
$errors = $errors ?? [];
$old = $old ?? [];
?>

<h1>Реєстрація на кінотеатр</h1>
<p>Заповніть форму для реєстрації як глядач кінотеатру. Вікові обмеження діють на окремі категорії фільмів.</p>

<?php if (!empty($errors)): ?>
    <div class="alert alert--error">
        <strong>Помилки при заповненні форми:</strong>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="index.php?route=regform/form" class="form">
    <div class="form__group">
        <label for="name" class="form__label">Ім'я</label>
        <input type="text" id="name" name="name"
               class="form__input<?= isset($errors['name']) ? ' form__input--error' : '' ?>"
               value="<?= htmlspecialchars($old['name'] ?? '') ?>"
               placeholder="Ваше ім'я">
        <?php if (isset($errors['name'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['name']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__group">
        <span class="form__label">Стать</span>
        <div class="form__radio-group">
            <label class="form__radio">
                <input type="radio" name="gender" value="male"
                       <?= (isset($old['gender']) && $old['gender'] === 'male') ? 'checked' : '' ?>>
                Чоловіча
            </label>
            <label class="form__radio">
                <input type="radio" name="gender" value="female"
                       <?= (isset($old['gender']) && $old['gender'] === 'female') ? 'checked' : '' ?>>
                Жіноча
            </label>
        </div>
        <?php if (isset($errors['gender'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['gender']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__group">
        <label class="form__label">Дата народження</label>
        <div class="form__date-group">
            <input type="number" name="day" min="1" max="31"
                   class="form__input form__input--small<?= isset($errors['birthdate']) ? ' form__input--error' : '' ?>"
                   value="<?= htmlspecialchars($old['day'] ?? '') ?>"
                   placeholder="ДД">
            <input type="number" name="month" min="1" max="12"
                   class="form__input form__input--small<?= isset($errors['birthdate']) ? ' form__input--error' : '' ?>"
                   value="<?= htmlspecialchars($old['month'] ?? '') ?>"
                   placeholder="ММ">
            <input type="number" name="year" min="1900" max="2100"
                   class="form__input form__input--small<?= isset($errors['birthdate']) ? ' form__input--error' : '' ?>"
                   value="<?= htmlspecialchars($old['year'] ?? '') ?>"
                   placeholder="РРРР">
        </div>
        <?php if (isset($errors['birthdate'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['birthdate']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__actions">
        <button type="submit" class="btn">Зареєструватися</button>
        <button type="reset" class="btn btn--secondary">Очистити</button>
    </div>
</form>
