<?php

class MovieController extends PageController
{
    private PDO $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();
        // ensure sample movies exist for demo
        $this->ensureSampleMovies();
    }

    public function action_list(): void
    {
        $sort = $_GET['sort'] ?? 'id';
        $order = $_GET['order'] ?? 'asc';
        $filterGenre = trim($_GET['genre'] ?? '');
        
        $allowedSorts = ['id', 'title', 'director', 'genre', 'year', 'duration_min'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }
        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'asc';
        }
        
        if ($filterGenre !== '') {
            $stmt = $this->db->prepare("SELECT * FROM movies WHERE genre = :genre ORDER BY {$sort} {$order}");
            $stmt->execute([':genre' => $filterGenre]);
        } else {
            $stmt = $this->db->prepare("SELECT * FROM movies ORDER BY {$sort} {$order}");
            $stmt->execute();
        }
        $movies = $stmt->fetchAll();

        // distinct genres for dropdown
        $gstmt = $this->db->prepare('SELECT DISTINCT genre FROM movies WHERE genre IS NOT NULL AND genre != "" ORDER BY genre');
        $gstmt->execute();
        $genres = array_map(function($r){ return $r['genre']; }, $gstmt->fetchAll());

        $this->render('movie/list', [
            'movies' => $movies,
            'currentSort' => $sort,
            'currentOrder' => $order,
            'genres' => $genres,
            'currentGenre' => $filterGenre,
        ], 'Фільми');
    }

    public function action_create(): void
    {
        if (!isset($_SESSION['user_id']) || !$this->isAdmin()) {
            $this->redirect('auth/login');
            return;
        }

        $errors = [];
        $old = [];

        if ($this->request->isPost()) {
            $old = $this->request->allPost();
            $errors = $this->validate($old);

            // Handle poster upload (optional)
            if (isset($_FILES['poster_image']) && $_FILES['poster_image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = DATA_DIR . '/uploads';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $ext = strtolower(pathinfo($_FILES['poster_image']['name'], PATHINFO_EXTENSION));
                $safeName = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                $dest = $uploadDir . '/' . $safeName;
                if (move_uploaded_file($_FILES['poster_image']['tmp_name'], $dest)) {
                    $old['poster_image'] = 'data/uploads/' . $safeName;
                }
            }

            if (empty($errors)) {
                $stmt = $this->db->prepare(
                    'INSERT INTO movies (title, director, genre, year, duration_min, poster_image, description, age_limit)
                     VALUES (:title, :director, :genre, :year, :duration_min, :poster_image, :description, :age_limit)'
                );
                $stmt->execute([
                    ':title' => trim($old['title']),
                    ':director' => trim($old['director']),
                    ':genre' => trim($old['genre'] ?? ''),
                    ':year' => (int)($old['year'] ?? 0),
                    ':duration_min' => (int)($old['duration_min'] ?? 0),
                    ':poster_image' => $old['poster_image'] ?? '',
                    ':description' => trim($old['description'] ?? ''),
                    ':age_limit' => isset($old['age_limit']) ? (int)$old['age_limit'] : 0,
                ]);

                $_SESSION['flash_success'] = 'Фільм "' . trim($old['title']) . '" додано!';
                $this->redirect('movie/list');
                return;
            }
        }

        $this->render('movie/create', [
            'errors' => $errors,
            'old' => $old,
        ], 'Додати фільм');
    }

    public function action_edit(): void
    {
        if (!isset($_SESSION['user_id']) || !$this->isAdmin()) {
            $this->redirect('auth/login');
            return;
        }

        $id = (int)$this->request->get('id', 0);

        if ($id <= 0) {
            $this->redirect('movie/list');
            return;
        }

        $stmt = $this->db->prepare('SELECT * FROM movies WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $movie = $stmt->fetch();

        if (!$movie) {
            $this->redirect('movie/list');
            return;
        }

        $errors = [];

        if ($this->request->isPost()) {
            $data = $this->request->allPost();
            $errors = $this->validate($data);
            // Handle poster upload if provided
            if (isset($_FILES['poster_image']) && $_FILES['poster_image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = DATA_DIR . '/uploads';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $ext = strtolower(pathinfo($_FILES['poster_image']['name'], PATHINFO_EXTENSION));
                $safeName = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                $dest = $uploadDir . '/' . $safeName;
                if (move_uploaded_file($_FILES['poster_image']['tmp_name'], $dest)) {
                    $data['poster_image'] = 'data/uploads/' . $safeName;
                }
            }

            if (empty($errors)) {
                $stmt = $this->db->prepare(
                    'UPDATE movies SET title = :title, director = :director, genre = :genre,
                     year = :year, duration_min = :duration_min, poster_image = :poster_image, description = :description, age_limit = :age_limit WHERE id = :id'
                );
                $stmt->execute([
                    ':title' => trim($data['title']),
                    ':director' => trim($data['director']),
                    ':genre' => trim($data['genre'] ?? ''),
                    ':year' => (int)($data['year'] ?? 0),
                    ':duration_min' => (int)($data['duration_min'] ?? 0),
                    ':poster_image' => $data['poster_image'] ?? $movie['poster_image'] ?? '',
                    ':description' => trim($data['description'] ?? ''),
                    ':age_limit' => isset($data['age_limit']) ? (int)$data['age_limit'] : ($movie['age_limit'] ?? 0),
                    ':id' => $id,
                ]);

                $_SESSION['flash_success'] = 'Фільм оновлено!';
                $this->redirect('movie/list');
                return;
            }

            $movie = array_merge($movie, $data);
        }

        $this->render('movie/edit', [
            'movie' => $movie,
            'errors' => $errors,
        ], 'Редагувати фільм');
    }

    public function action_delete(): void
    {
        if (!isset($_SESSION['user_id']) || !$this->isAdmin()) {
            $this->redirect('auth/login');
            return;
        }

        if ($this->request->isPost()) {
            $id = (int)$this->request->post('id', 0);

            if ($id > 0) {
                $stmt = $this->db->prepare('DELETE FROM movies WHERE id = :id');
                $stmt->execute([':id' => $id]);
                $_SESSION['flash_success'] = 'Фільм видалено!';
            }
        }

        $this->redirect('movie/list');
    }

    private function validate(array $data): array
    {
        $errors = [];

        if (trim($data['title'] ?? '') === '') {
            $errors['title'] = 'Назва фільму є обов\'язковою.';
        }

        if (trim($data['director'] ?? '') === '') {
            $errors['director'] = 'Режисер є обов\'язковим.';
        }

        $year = $data['year'] ?? '';
        if ($year !== '' && (!is_numeric($year) || (int)$year < 1888 || (int)$year > date('Y') + 1)) {
            $errors['year'] = 'Рік має бути між 1888 та ' . (date('Y') + 1) . '.';
        }

        $duration = $data['duration_min'] ?? '';
        if ($duration !== '' && (!is_numeric($duration) || (int)$duration < 1)) {
            $errors['duration_min'] = 'Тривалість має бути не менше 1 хвилини.';
        }

        return $errors;
    }

    // ===== GALLERY VIEW =====
    public function action_gallery(): void
    {
        $this->ensureSampleMovies();
        $stmt = $this->db->prepare(
            "SELECT m.*, COUNT(DISTINCT mc.id) as comments_count, 
                    COUNT(DISTINCT mr.id) as reactions_count
             FROM movies m
             LEFT JOIN movie_comments mc ON m.id = mc.movie_id
             LEFT JOIN movie_reactions mr ON m.id = mr.movie_id
             GROUP BY m.id
             ORDER BY m.id"
        );
        $stmt->execute();
        $movies = $stmt->fetchAll();

        $this->render('movie/gallery', [
            'movies' => $movies,
        ], 'Галерея фільмів');
    }

    private function ensureSampleMovies(): void
    {
        // Insert sample movies if they don't already exist (idempotent)
        $samples = [
            ['title'=>'Диявол носить Prada','director'=>'David Frankel','genre'=>'Drama','year'=>2006,'duration'=>109,'description'=>'Комедія-драма про молодого журналіста та кастинг у світі моди.'],
            ['title'=>'Як приборкати дракона','director'=>'Dean DeBlois','genre'=>'Animation','year'=>2010,'duration'=>98,'description'=>'Пригодницький анімаційний фільм про дружбу хлопчика і дракона.'],
            ['title'=>'Гаррі Поттер і філософський камінь','director'=>'Chris Columbus','genre'=>'Fantasy','year'=>2001,'duration'=>152,'description'=>'Початок пригод Гаррі Поттера у школі чарівництва Хогвартс.'],
            ['title'=>'Чорна Вдова','director'=>'Cate Shortland','genre'=>'Action','year'=>2021,'duration'=>134,'description'=>'Супергеройський екшен про Наташу Романову та її минуле.'],
            ['title'=>'Людина-павук: Повернення додому','director'=>'Jon Watts','genre'=>'Action','year'=>2017,'duration'=>133,'description'=>'Повернення Пітера Паркера до звичайного шкільного життя, поки він бореться зі злочинністю.' ],
            // Marvel examples
            ['title'=>'Залізна Людина','director'=>'Jon Favreau','genre'=>'Action','year'=>2008,'duration'=>126,'description'=>'Науково-фантастичний бойовик про винахідника та мільярдера, який стає супергероєм.' ],
            ['title'=>'Тор','director'=>'Kenneth Branagh','genre'=>'Action','year'=>2011,'duration'=>115,'description'=>'Епічний фільм, що поєднує нордичну міфологію й супергеройські мотиви.' ],
            ['title'=>'Капітан Америка: Перший месник','director'=>'Joe Johnston','genre'=>'Action','year'=>2011,'duration'=>124,'description'=>'Походження героя-криштального лідера, який бореться за справедливість.' ],
            ['title'=>'Месники','director'=>'Joss Whedon','genre'=>'Action','year'=>2012,'duration'=>143,'description'=>'Команда супергероїв об’єднується, щоб врятувати світ.' ],
            ['title'=>'Людина-павук: Далеко від дому','director'=>'Jon Watts','genre'=>'Action','year'=>2019,'duration'=>129,'description'=>'Подальші пригоди Пітера Паркера під час подорожі Європою.' ],
        ];

        $ins = $this->db->prepare('INSERT INTO movies (title,director,genre,year,duration_min,poster_image,description,age_limit) VALUES (:title,:director,:genre,:year,:duration,:poster,:desc,:age)');
        // prepare screening insert
        $insS = $this->db->prepare('INSERT INTO screenings (movie_id,hall_id,screening_datetime,price_per_ticket) VALUES (:mid,:hid,:dt,:price)');
        foreach ($samples as $s) {
            // check if movie title exists
            $chk = $this->db->prepare('SELECT id FROM movies WHERE title = :title LIMIT 1');
            $chk->execute([':title' => $s['title']]);
            $existing = $chk->fetchColumn();
            if ($existing) {
                // ensure there are some screenings for this movie
                $sc = $this->db->prepare('SELECT COUNT(*) FROM screenings WHERE movie_id = :mid');
                $sc->execute([':mid' => (int)$existing]);
                if ((int)$sc->fetchColumn() === 0) {
                    $times = ['13:00:00','16:30:00','19:00:00'];
                    for ($d=0;$d<3;$d++) {
                        foreach ($times as $t) {
                            $dt = date('Y-m-d', strtotime("+{$d} days")) . ' ' . $t;
                            $insS->execute([':mid'=>(int)$existing, ':hid'=>1, ':dt'=>$dt, ':price'=>150.00]);
                        }
                    }
                }
                // if description is empty, update it from sample data
                if (!empty($s['description'])) {
                    $u = $this->db->prepare('UPDATE movies SET description = :desc WHERE id = :id AND (description IS NULL OR description = "")');
                    $u->execute([':desc' => $s['description'], ':id' => (int)$existing]);
                }
                continue;
            }

            $ins->execute([
                ':title'=>$s['title'], ':director'=>$s['director'], ':genre'=>$s['genre'], ':year'=>$s['year'], ':duration'=>$s['duration'], ':poster'=>'', ':desc'=>$s['description'] ?? '', ':age'=>0
            ]);
            $mid = (int)$this->db->lastInsertId();
            // add screenings for next 3 days at multiple times
            $times = ['13:00:00','16:30:00','19:00:00'];
            for ($d=0;$d<3;$d++) {
                foreach ($times as $t) {
                    $dt = date('Y-m-d', strtotime("+{$d} days")) . ' ' . $t;
                    $insS->execute([':mid'=>$mid, ':hid'=>1, ':dt'=>$dt, ':price'=>150.00]);
                }
            }
        }
    }

    // ===== MOVIE DETAILS =====
    public function action_detail(): void
    {
        $id = (int)$this->request->get('id', 0);
        if ($id <= 0) {
            $this->redirect('movie/gallery');
            return;
        }

        // Get movie
        $stmt = $this->db->prepare('SELECT * FROM movies WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $movie = $stmt->fetch();

        if (!$movie) {
            $this->redirect('movie/gallery');
            return;
        }

        // Get comments with user info
        $stmt = $this->db->prepare(
            "SELECT mc.*, u.first_name, u.last_name, u.login
             FROM movie_comments mc
             JOIN users u ON mc.user_id = u.id
             WHERE mc.movie_id = :id
             ORDER BY mc.created_at DESC"
        );
        $stmt->execute([':id' => $id]);
        $comments = $stmt->fetchAll();

        // Get reactions count
        $stmt = $this->db->prepare(
            "SELECT reaction_type, COUNT(*) as count
             FROM movie_reactions
             WHERE movie_id = :id
             GROUP BY reaction_type"
        );
        $stmt->execute([':id' => $id]);
        $reactions = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        // Get user's reaction if logged in
        $userReaction = null;
        $userComment = null;
        if (isset($_SESSION['user_id'])) {
            $stmt = $this->db->prepare(
                "SELECT reaction_type FROM movie_reactions
                 WHERE movie_id = :id AND user_id = :uid"
            );
            $stmt->execute([':id' => $id, ':uid' => $_SESSION['user_id']]);
            $userReaction = $stmt->fetchColumn();

            $stmt = $this->db->prepare(
                "SELECT id, comment, rating FROM movie_comments
                 WHERE movie_id = :id AND user_id = :uid LIMIT 1"
            );
            $stmt->execute([':id' => $id, ':uid' => $_SESSION['user_id']]);
            $userComment = $stmt->fetch();
        }

        // Get polls for this movie
        $stmt = $this->db->prepare(
            "SELECT p.*, COUNT(DISTINCT pv.id) as total_votes
             FROM movie_polls p
             LEFT JOIN poll_votes pv ON p.id = pv.poll_id
             WHERE p.movie_id = :id AND p.active = 1
             GROUP BY p.id"
        );
        $stmt->execute([':id' => $id]);
        $polls = $stmt->fetchAll();

        // For each poll, get options with vote counts
        foreach ($polls as &$poll) {
            $stmt = $this->db->prepare(
                "SELECT po.*, COUNT(pv.id) as vote_count
                 FROM poll_options po
                 LEFT JOIN poll_votes pv ON po.id = pv.option_id
                 WHERE po.poll_id = :pid
                 GROUP BY po.id"
            );
            $stmt->execute([':pid' => $poll['id']]);
            $poll['options'] = $stmt->fetchAll();

            // Check if user voted
            $poll['user_voted'] = false;
            $poll['user_vote_option'] = null;
            if (isset($_SESSION['user_id'])) {
                $stmt = $this->db->prepare(
                    "SELECT option_id FROM poll_votes
                     WHERE poll_id = :pid AND user_id = :uid"
                );
                $stmt->execute([':pid' => $poll['id'], ':uid' => $_SESSION['user_id']]);
                $vote = $stmt->fetch();
                if ($vote) {
                    $poll['user_voted'] = true;
                    $poll['user_vote_option'] = $vote['option_id'];
                }
            }
        }

        // Get screenings for this movie
        $stmt = $this->db->prepare(
            "SELECT s.*, h.name as hall_name
             FROM screenings s
             JOIN halls h ON s.hall_id = h.id
             WHERE s.movie_id = :id
             AND s.screening_datetime > datetime('now')
             ORDER BY s.screening_datetime"
        );
        $stmt->execute([':id' => $id]);
        $screenings = $stmt->fetchAll();

        // Ensure at least 5 distinct days of screenings exist for this movie
        $dates = [];
        foreach ($screenings as $s) {
            $d = substr($s['screening_datetime'], 0, 10);
            $dates[$d] = true;
        }
        $distinctDays = count($dates);

        if ($distinctDays < 5) {
            // generate additional screenings on subsequent days at common times
            $times = ['18:00:00', '19:30:00', '21:00:00', '16:00:00', '13:00:00'];
            $added = 0;
            $dayOffset = 0;
            while ($distinctDays + $added < 5 && $dayOffset < 30) {
                $dayOffset++;
                $candidateDate = date('Y-m-d', strtotime("+{$dayOffset} days"));
                if (isset($dates[$candidateDate])) continue;
                // pick a time
                $time = $times[$added % count($times)];
                $dt = $candidateDate . ' ' . $time;
                // check if exists
                $chk = $this->db->prepare('SELECT COUNT(*) FROM screenings WHERE movie_id = :mid AND screening_datetime = :dt');
                $chk->execute([':mid' => $id, ':dt' => $dt]);
                if ((int)$chk->fetchColumn() === 0) {
                    // use hall_id from first screening or default 1
                    $hallId = $screenings[0]['hall_id'] ?? 1;
                    $price = $screenings[0]['price_per_ticket'] ?? 150.00;
                    $ins = $this->db->prepare('INSERT INTO screenings (movie_id, hall_id, screening_datetime, price_per_ticket) VALUES (:mid, :hid, :dt, :price)');
                    $ins->execute([':mid' => $id, ':hid' => $hallId, ':dt' => $dt, ':price' => $price]);
                    $added++;
                }
            }

            // reload screenings
            $stmt = $this->db->prepare(
                "SELECT s.*, h.name as hall_name
                 FROM screenings s
                 JOIN halls h ON s.hall_id = h.id
                 WHERE s.movie_id = :id
                 AND s.screening_datetime > datetime('now')
                 ORDER BY s.screening_datetime"
            );
            $stmt->execute([':id' => $id]);
            $screenings = $stmt->fetchAll();
        }

        $this->render('movie/detail', [
            'movie' => $movie,
            'comments' => $comments,
            'reactions' => $reactions,
            'userReaction' => $userReaction,
            'userComment' => $userComment,
            'polls' => $polls,
            'screenings' => $screenings,
        ], htmlspecialchars($movie['title']));
    }

    // ===== ADD COMMENT =====
    public function action_add_comment(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        $movieId = (int)$this->request->post('movie_id', 0);
        $text = trim($this->request->post('comment', ''));
        $rating = (int)$this->request->post('rating', 5);

        if ($movieId > 0 && !empty($text)) {
            // Delete old comment if exists
            $stmt = $this->db->prepare(
                'DELETE FROM movie_comments WHERE movie_id = :mid AND user_id = :uid'
            );
            $stmt->execute([':mid' => $movieId, ':uid' => $_SESSION['user_id']]);

            // Add new comment
            $stmt = $this->db->prepare(
                'INSERT INTO movie_comments (movie_id, user_id, comment, rating)
                 VALUES (:mid, :uid, :comment, :rating)'
            );
            $stmt->execute([
                ':mid' => $movieId,
                ':uid' => $_SESSION['user_id'],
                ':comment' => $text,
                ':rating' => max(1, min(10, $rating)),
            ]);

            $_SESSION['flash_success'] = 'Коментар додано!';
        }

        $this->redirect('movie/detail&id=' . $movieId);
    }

    // ===== ADD REACTION =====
    public function action_add_reaction(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        $movieId = (int)$this->request->post('movie_id', 0);
        $type = $this->request->post('reaction_type', 'like');
        $type = in_array($type, ['like', 'dislike']) ? $type : 'like';

        if ($movieId > 0) {
            try {
                $stmt = $this->db->prepare(
                    'INSERT OR REPLACE INTO movie_reactions (movie_id, user_id, reaction_type)
                     VALUES (:mid, :uid, :type)'
                );
                $stmt->execute([
                    ':mid' => $movieId,
                    ':uid' => $_SESSION['user_id'],
                    ':type' => $type,
                ]);
            } catch (PDOException $e) {
                // Handle duplicate key
            }
        }

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }

    // ===== VOTE ON POLL =====
    public function action_vote_poll(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Not logged in']);
            exit;
        }

        $pollId = (int)$this->request->post('poll_id', 0);
        $optionId = (int)$this->request->post('option_id', 0);

        if ($pollId > 0 && $optionId > 0) {
            try {
                // Delete old vote if exists
                $stmt = $this->db->prepare(
                    'DELETE FROM poll_votes WHERE poll_id = :pid AND user_id = :uid'
                );
                $stmt->execute([':pid' => $pollId, ':uid' => $_SESSION['user_id']]);

                // Add new vote
                $stmt = $this->db->prepare(
                    'INSERT INTO poll_votes (poll_id, option_id, user_id)
                     VALUES (:pid, :oid, :uid)'
                );
                $stmt->execute([
                    ':pid' => $pollId,
                    ':oid' => $optionId,
                    ':uid' => $_SESSION['user_id'],
                ]);

                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
                exit;
            } catch (PDOException $e) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Vote failed']);
                exit;
            }
        }

        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid data']);
        exit;
    }

    // ===== TICKET PURCHASE =====
    public function action_buy_ticket(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        $screeningId = (int)($this->request->post('screening_id', $this->request->get('screening_id', 0)));

        // Get screening info
        $stmt = $this->db->prepare(
            "SELECT s.*, m.title, m.poster_image, h.name as hall_name
             FROM screenings s
             JOIN movies m ON s.movie_id = m.id
             JOIN halls h ON s.hall_id = h.id
             WHERE s.id = :id"
        );
        $stmt->execute([':id' => $screeningId]);
        $screening = $stmt->fetch();

        if (!$screening) {
            $this->redirect('movie/detail');
            return;
        }

        // Get hall seats
        $stmt = $this->db->prepare(
            "SELECT hs.*, 
                    (SELECT COUNT(*) FROM tickets t 
                     WHERE t.seat_id = hs.id AND t.screening_id = :sid) as is_booked
             FROM hall_seats hs
             WHERE hs.hall_id = :hid
             ORDER BY hs.row_num, hs.seat_num"
        );
        $stmt->execute([':sid' => $screeningId, ':hid' => $screening['hall_id']]);
        $seats = $stmt->fetchAll();

        $errors = [];
        $selectedSeats = [];

        if ($this->request->isPost()) {
            $selectedSeats = $this->request->post('seats', []);
            if (!is_array($selectedSeats)) {
                $selectedSeats = [];
            }

            if (empty($selectedSeats)) {
                $errors[] = 'Оберіть щонайменше одне місце.';
            } else {
                // Validate seats
                $seatIds = array_map('intval', $selectedSeats);
                $placeholders = implode(',', $seatIds);

                $stmt = $this->db->prepare(
                    "SELECT COUNT(*) FROM tickets
                     WHERE screening_id = :sid AND seat_id IN ({$placeholders})"
                );
                $stmt->execute([':sid' => $screeningId]);
                $booked = $stmt->fetchColumn();

                if ($booked > 0) {
                    $errors[] = 'Деякі місця вже забронены. Спробуйте знову.';
                }

                if (empty($errors)) {
                    // Create tickets and remember ticket numbers
                    $created = [];
                    foreach ($seatIds as $seatId) {
                        $ticketNumber = 'TKT-' . date('YmdHis') . '-' . rand(1000, 9999);
                        $stmt = $this->db->prepare(
                            'INSERT INTO tickets (screening_id, user_id, seat_id, ticket_number, price)
                             VALUES (:sid, :uid, :seat, :ticket, :price)'
                        );
                        $stmt->execute([
                            ':sid' => $screeningId,
                            ':uid' => $_SESSION['user_id'],
                            ':seat' => $seatId,
                            ':ticket' => $ticketNumber,
                            ':price' => $screening['price_per_ticket'],
                        ]);
                        $created[] = $ticketNumber;
                    }

                    // Fetch created tickets to show receipt
                    $in = implode(',', array_fill(0, count($created), '?'));
                    $q = $this->db->prepare("SELECT t.*, hs.row_num, hs.seat_num, s.screening_datetime, m.title, m.poster_image
                                              FROM tickets t
                                              JOIN hall_seats hs ON t.seat_id = hs.id
                                              JOIN screenings s ON t.screening_id = s.id
                                              JOIN movies m ON s.movie_id = m.id
                                              WHERE t.ticket_number IN ($in)");
                    $q->execute($created);
                    $tickets = $q->fetchAll();

                    $total = 0;
                    foreach ($tickets as $t) $total += $t['price'];

                    $this->render('movie/receipt', [
                        'tickets' => $tickets,
                        'total' => $total,
                        'screening' => $screening,
                    ], 'Чек покупки');
                    return;
                }
            }
        }

        $this->render('movie/buy_ticket', [
            'screening' => $screening,
            'seats' => $seats,
            'selectedSeats' => $selectedSeats,
            'errors' => $errors,
        ], 'Купити квитки');
    }

    // ===== CREATE SCREENING =====
    public function action_create_screening(): void
    {
        if (!isset($_SESSION['user_id']) || !$this->isAdmin()) {
            $this->redirect('auth/login');
            return;
        }

        $movieId = (int)$this->request->get('movie_id', 0);
        if ($movieId <= 0) {
            $this->redirect('movie/list');
            return;
        }

        $stmt = $this->db->prepare('SELECT * FROM movies WHERE id = :id');
        $stmt->execute([':id' => $movieId]);
        $movie = $stmt->fetch();

        if (!$movie) {
            $this->redirect('movie/list');
            return;
        }

        $stmt = $this->db->prepare('SELECT * FROM halls');
        $stmt->execute();
        $halls = $stmt->fetchAll();

        $errors = [];
        $old = [];

        if ($this->request->isPost()) {
            $old = $this->request->allPost();
            $datetime = $old['screening_datetime'] ?? '';
            $hallId = (int)($old['hall_id'] ?? 0);
            $price = (float)($old['price_per_ticket'] ?? 0);

            if ($datetime === '') {
                $errors['screening_datetime'] = 'Дата та час є обов\'язковими.';
            }
            if ($hallId <= 0) {
                $errors['hall_id'] = 'Зала є обов\'язковою.';
            }
            if ($price <= 0) {
                $errors['price_per_ticket'] = 'Ціна повинна бути більше 0.';
            }

            if (empty($errors)) {
                $stmt = $this->db->prepare(
                    'INSERT INTO screenings (movie_id, hall_id, screening_datetime, price_per_ticket)
                     VALUES (:mid, :hid, :dt, :price)'
                );
                $stmt->execute([
                    ':mid' => $movieId,
                    ':hid' => $hallId,
                    ':dt' => $datetime,
                    ':price' => $price,
                ]);

                $_SESSION['flash_success'] = 'Сеанс додано!';
                $this->redirect('movie/detail&id=' . $movieId);
                return;
            }
        }

        $this->render('movie/create_screening', [
            'movie' => $movie,
            'halls' => $halls,
            'errors' => $errors,
            'old' => $old,
        ], 'Додати сеанс');
    }

    // ===== API: DETAIL FOR MODAL =====
    public function action_api_detail(): void
    {
        $id = (int)$this->request->get('id', 0);
        if ($id <= 0) {
            header('HTTP/1.1 400 Bad Request');
            echo 'Invalid id';
            exit;
        }

        $stmt = $this->db->prepare('SELECT * FROM movies WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $movie = $stmt->fetch();

        if (!$movie) {
            header('HTTP/1.1 404 Not Found');
            echo 'Not found';
            exit;
        }

        // Get upcoming screenings
        $stmt = $this->db->prepare(
            "SELECT s.*, h.name as hall_name FROM screenings s JOIN halls h ON s.hall_id = h.id WHERE s.movie_id = :id AND s.screening_datetime > datetime('now') ORDER BY s.screening_datetime"
        );
        $stmt->execute([':id' => $id]);
        $screenings = $stmt->fetchAll();

        // Get comments (latest 10)
        $stmt = $this->db->prepare(
            "SELECT mc.*, u.first_name, u.last_name FROM movie_comments mc JOIN users u ON mc.user_id = u.id WHERE mc.movie_id = :id ORDER BY mc.created_at DESC LIMIT 10"
        );
        $stmt->execute([':id' => $id]);
        $comments = $stmt->fetchAll();

        // Get reactions counts
        $stmt = $this->db->prepare(
            "SELECT reaction_type, COUNT(*) as count FROM movie_reactions WHERE movie_id = :id GROUP BY reaction_type"
        );
        $stmt->execute([':id' => $id]);
        $reactions = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        $this->render('movie/detail_partial', [
            'movie' => $movie,
            'screenings' => $screenings,
            'comments' => $comments,
            'reactions' => $reactions,
        ]);
        exit;
    }

    // ===== MY TICKETS =====
    public function action_my_tickets(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        $stmt = $this->db->prepare(
            "SELECT t.*, m.title, m.poster_image, hs.row_num, hs.seat_num, s.screening_datetime
             FROM tickets t
             JOIN screenings s ON t.screening_id = s.id
             JOIN movies m ON s.movie_id = m.id
             JOIN hall_seats hs ON t.seat_id = hs.id
             WHERE t.user_id = :uid
             ORDER BY t.purchase_datetime DESC"
        );
        $stmt->execute([':uid' => $_SESSION['user_id']]);
        $tickets = $stmt->fetchAll();

        $this->render('movie/my_tickets', [
            'tickets' => $tickets,
        ], 'Мої квитки');
    }

    // ===== CANCEL TICKET =====
    public function action_cancel_ticket(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        if ($this->request->isPost()) {
            $ticketId = (int)$this->request->post('ticket_id', 0);
            if ($ticketId > 0) {
                // Only allow owner to cancel
                $stmt = $this->db->prepare('SELECT user_id FROM tickets WHERE id = :id');
                $stmt->execute([':id' => $ticketId]);
                $owner = $stmt->fetchColumn();
                if ($owner && (int)$owner === (int)$_SESSION['user_id']) {
                    $stmt = $this->db->prepare('UPDATE tickets SET booking_status = :status WHERE id = :id');
                    $stmt->execute([':status' => 'cancelled', ':id' => $ticketId]);
                    $_SESSION['flash_success'] = 'Квиток скасовано.';
                }
            }
        }

        $this->redirect('movie/my_tickets');
    }

    private function isAdmin(): bool
    {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        
        try {
            $stmt = $this->db->prepare('SELECT is_admin FROM users WHERE id = :id');
            $stmt->execute([':id' => $_SESSION['user_id']]);
            $user = $stmt->fetch();
            
            // If column doesn't exist or user not found, check if user is 'admin' by login
            if (!$user || $user === false) {
                // Fallback: check by login name
                $stmt = $this->db->prepare('SELECT login FROM users WHERE id = :id');
                $stmt->execute([':id' => $_SESSION['user_id']]);
                $user = $stmt->fetch();
                return $user && $user['login'] === 'admin';
            }
            
            return (bool)($user['is_admin'] ?? false);
        } catch (Exception $e) {
            // If query fails, check by login as fallback
            try {
                $stmt = $this->db->prepare('SELECT login FROM users WHERE id = :id');
                $stmt->execute([':id' => $_SESSION['user_id']]);
                $user = $stmt->fetch();
                return $user && $user['login'] === 'admin';
            } catch (Exception $e2) {
                return false;
            }
        }
    }
}
