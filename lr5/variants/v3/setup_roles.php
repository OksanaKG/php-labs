<?php
$db = new PDO('sqlite:database/app.db');

// Add is_admin column if it doesn't exist
try {
    $db->exec('ALTER TABLE users ADD COLUMN is_admin BOOLEAN DEFAULT 0');
    echo "Додано стовпець is_admin" . PHP_EOL;
} catch (Exception $e) {
    if (strpos($e->getMessage(), 'duplicate column') === false) {
        echo "Помилка: " . $e->getMessage() . PHP_EOL;
    } else {
        echo "Стовпець is_admin вже існує" . PHP_EOL;
    }
}

// Set admin status for admin user
$stmt = $db->prepare('UPDATE users SET is_admin = 1 WHERE login = ?');
$stmt->execute(['admin']);
echo "Користувач 'admin' має права адміністратора" . PHP_EOL;
