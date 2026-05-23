<?php
$dbFile = __DIR__ . '/../database/app.db';
if (!file_exists($dbFile)) {
    echo "DB file not found: $dbFile\n";
    exit(1);
}

try {
    $pdo = new PDO('sqlite:' . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if age_limit column exists
    $cols = $pdo->query("PRAGMA table_info(movies);")->fetchAll(PDO::FETCH_ASSOC);
    $hasAge = false;
    foreach ($cols as $c) {
        if ($c['name'] === 'age_limit') { $hasAge = true; break; }
    }
    if (!$hasAge) {
        echo "Adding age_limit column...\n";
        $pdo->exec("ALTER TABLE movies ADD COLUMN age_limit INTEGER DEFAULT 0;");
    } else {
        echo "age_limit column already exists.\n";
    }

    // Update movie titles to Ukrainian if English present
    $map = [
        'Pulp Fiction' => 'Кримінальне чтиво',
        'The Shawshank Redemption' => 'Втеча з Шоушенка',
        'Inception' => 'Початок',
        'The Godfather' => 'Хрещений батько',
        'Forrest Gump' => 'Форрест Гамп',
        'The Matrix' => 'Матриця',
        'Titanic' => 'Титанік',
        'Avatar' => 'Аватар',
        'The Dark Knight' => 'Темний лицар',
        "Schindler's List" => 'Список Шиндлера',
    ];

    foreach ($map as $eng => $ua) {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM movies WHERE title = :eng');
        $stmt->execute([':eng' => $eng]);
        $cnt = (int)$stmt->fetchColumn();
        if ($cnt > 0) {
            echo "Updating title: $eng -> $ua\n";
            $up = $pdo->prepare('UPDATE movies SET title = :ua WHERE title = :eng');
            $up->execute([':ua' => $ua, ':eng' => $eng]);
        }
    }

    // Insert sample screenings if not present
    $samples = [
        ['title' => 'Кримінальне чтиво', 'dt' => date('Y-m-d H:i', strtotime('+1 day 19:00')), 'price' => 150.00],
        ['title' => 'Втеча з Шоушенка', 'dt' => date('Y-m-d H:i', strtotime('+1 day 21:30')), 'price' => 160.00],
        ['title' => 'Початок', 'dt' => date('Y-m-d H:i', strtotime('+2 days 18:30')), 'price' => 180.00],
        ['title' => 'Хрещений батько', 'dt' => date('Y-m-d H:i', strtotime('+2 days 20:30')), 'price' => 140.00],
        ['title' => 'Матриця', 'dt' => date('Y-m-d H:i', strtotime('+3 days 19:00')), 'price' => 170.00],
    ];

    foreach ($samples as $s) {
        // find movie id
        $stmt = $pdo->prepare('SELECT id FROM movies WHERE title = :t LIMIT 1');
        $stmt->execute([':t' => $s['title']]);
        $mid = $stmt->fetchColumn();
        if (!$mid) {
            echo "Movie not found for screenings: {$s['title']}\n";
            continue;
        }
        // check if similar screening exists
        $chk = $pdo->prepare('SELECT COUNT(*) FROM screenings WHERE movie_id = :mid AND screening_datetime = :dt');
        $chk->execute([':mid' => $mid, ':dt' => $s['dt']]);
        if ((int)$chk->fetchColumn() === 0) {
            $ins = $pdo->prepare('INSERT INTO screenings (movie_id, hall_id, screening_datetime, price_per_ticket) VALUES (:mid, :hid, :dt, :price)');
            $ins->execute([':mid' => $mid, ':hid' => 1, ':dt' => $s['dt'], ':price' => $s['price']]);
            echo "Inserted screening for {$s['title']} at {$s['dt']}\n";
        } else {
            echo "Screening already exists for {$s['title']} at {$s['dt']}\n";
        }
    }

    echo "Migration finished.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
