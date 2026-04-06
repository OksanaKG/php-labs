<?php
try {
    $db = new PDO('sqlite:database/app.db');
    
    echo "=== Діагностика бази даних ===" . PHP_EOL . PHP_EOL;
    
    // Check users table structure
    echo "1. Виявлення структури таблиці users:" . PHP_EOL;
    $stmt = $db->query("PRAGMA table_info(users)");
    $columns = $stmt->fetchAll();
    foreach ($columns as $col) {
        echo "   - {$col['name']} ({$col['type']})" . PHP_EOL;
    }
    echo PHP_EOL;
    
    // Check if is_admin column exists
    $hasIsAdmin = false;
    foreach ($columns as $col) {
        if ($col['name'] === 'is_admin') {
            $hasIsAdmin = true;
            break;
        }
    }
    
    if (!$hasIsAdmin) {
        echo "2. ⚠️ Стовпець is_admin НЕ залишається! Додаємо..." . PHP_EOL;
        $db->exec('ALTER TABLE users ADD COLUMN is_admin BOOLEAN DEFAULT 0');
        echo "   ✓ Стовпець додано" . PHP_EOL . PHP_EOL;
    } else {
        echo "2. ✓ Стовпець is_admin існує" . PHP_EOL . PHP_EOL;
    }
    
    // Set admin flag for admin user
    echo "3. Встановлення прав адміністратора:" . PHP_EOL;
    $stmt = $db->prepare('UPDATE users SET is_admin = 1 WHERE login = ?');
    $stmt->execute(['admin']);
    echo "   ✓ Користувач 'admin' отримав права адміністратора" . PHP_EOL . PHP_EOL;
    
    // Show all users
    echo "4. Поточні користувачі:" . PHP_EOL;
    $users = $db->query('SELECT id, login, is_admin FROM users')->fetchAll();
    if (empty($users)) {
        echo "   ❌ КОРИСТУВАЧІВ НЕМАЄ!" . PHP_EOL;
    } else {
        foreach ($users as $user) {
            $role = $user['is_admin'] ? '✓ ADMIN' : '  USER';
            echo "   [$role] ID={$user['id']} login={$user['login']}" . PHP_EOL;
        }
    }
    
    echo PHP_EOL . "✓ Діагностика завершена" . PHP_EOL;
    
} catch (Exception $e) {
    echo "❌ Помилка: " . $e->getMessage() . PHP_EOL;
}
