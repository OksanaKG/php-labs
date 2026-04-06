<?php
try {
    $db = new PDO('sqlite:database/app.db');
    
    // Try to add is_admin column
    try {
        $db->exec('ALTER TABLE users ADD COLUMN is_admin BOOLEAN DEFAULT 0');
        echo "✓ Додано стовпець is_admin" . PHP_EOL;
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'duplicate column') !== false) {
            echo "✓ Стовпець is_admin вже існує" . PHP_EOL;
        } else {
            throw $e;
        }
    }
    
    // Set admin status for admin user
    $stmt = $db->prepare('UPDATE users SET is_admin = 1 WHERE login = ?');
    $stmt->execute(['admin']);
    echo "✓ Користувач 'admin' має права адміністратора" . PHP_EOL;
    
    // Show current users
    $users = $db->query('SELECT login, is_admin FROM users')->fetchAll();
    echo "\nТекучі користувачи:" . PHP_EOL;
    foreach ($users as $user) {
        $role = $user['is_admin'] ? '[ADMIN]' : '[USER]';
        echo "  $role " . $user['login'] . PHP_EOL;
    }
    
} catch (Exception $e) {
    echo "Помилка: " . $e->getMessage() . PHP_EOL;
}
