<?php
$comments = $comments ?? [];
$message = $message ?? '';
$errors = $errors ?? [];
$isLoggedIn = isset($_SESSION['user_id']);
$userId = $_SESSION['user_id'] ?? null;

// Check if current user is admin
$isAdmin = false;
if ($isLoggedIn) {
    try {
        $db = new PDO('sqlite:database/app.db');
        $stmt = $db->prepare('SELECT is_admin FROM users WHERE id = :id');
        $stmt->execute([':id' => $userId]);
        $user = $stmt->fetch();
        if ($user && (bool)$user['is_admin']) {
            $isAdmin = true;
        }
    } catch (Exception $e) {
        // Fallback: check by login name
        try {
            $db = new PDO('sqlite:database/app.db');
            $stmt = $db->prepare('SELECT login FROM users WHERE id = :id');
            $stmt->execute([':id' => $userId]);
            $user = $stmt->fetch();
            if ($user && $user['login'] === 'admin') {
                $isAdmin = true;
            }
        } catch (Exception $e2) {
            // Continue without admin check
        }
    }
}
?>

<h1>Гостьова книга</h1>
<p>Коментарі глядачів зберігаються у файлі <code>data/comments.jsonl</code> (формат: JSON Lines).</p>

<?php if ($message !== ''): ?>
    <div class="alert alert--success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert--error">
        <ul>
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<h2>Додати коментар</h2>
<form method="POST" action="index.php?route=guestbook/index" class="form">
    <div class="form__group <?= isset($errors['name']) ? 'form__group--error' : '' ?>">
        <label for="gb_name" class="form__label">Ім'я <span class="required">*</span></label>
        <input type="text" id="gb_name" name="name" class="form__input"
               value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
               placeholder="Ваше ім'я">
        <?php if (isset($errors['name'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['name']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__group <?= isset($errors['comment']) ? 'form__group--error' : '' ?>">
        <label for="gb_comment" class="form__label">Коментар <span class="required">*</span></label>
        <textarea id="gb_comment" name="comment" class="form__textarea"
                  placeholder="Поділіться враженнями про фільми..."><?= htmlspecialchars($_POST['comment'] ?? '') ?></textarea>
        <?php if (isset($errors['comment'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['comment']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__actions">
        <button type="submit" class="btn">Додати</button>
    </div>
</form>

<h2>Коментарі (<?= count($comments) ?>)</h2>

<?php if (empty($comments)): ?>
    <p class="text-muted">Поки що коментарів немає.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>Дата</th>
                <th>Ім'я</th>
                <th>Коментар</th>
                <?php if ($isLoggedIn): ?>
                    <th>Дії</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comments as $index => $c): ?>
                <tr>
                    <td><?= htmlspecialchars($c['date']) ?></td>
                    <td><?= htmlspecialchars($c['name']) ?></td>
                    <td><?= htmlspecialchars($c['comment']) ?></td>
                    <?php 
                        $canDelete = false;
                        if ($isAdmin) {
                            $canDelete = true;
                        } elseif ($isLoggedIn && isset($c['user_id']) && $c['user_id'] == $userId) {
                            $canDelete = true;
                        }
                    ?>
                    <?php if ($isLoggedIn && $canDelete): ?>
                        <td>
                            <form method="POST" action="index.php?route=guestbook/index" style="display:inline"
                                  onsubmit="return confirm('Видалити коментар?')">
                                <input type="hidden" name="delete_index" value="<?= $index ?>">
                                <button type="submit" class="btn btn--small btn--danger">Видалити</button>
                            </form>
                        </td>
                    <?php elseif ($isLoggedIn): ?>
                        <td><span style="color: #999; font-size: 0.9em;">Не ваш</span></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
