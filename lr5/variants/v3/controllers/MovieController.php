<?php

class MovieController extends PageController
{
    private PDO $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();
    }

    public function action_list(): void
    {
        $sort = $_GET['sort'] ?? 'id';
        $order = $_GET['order'] ?? 'asc';
        
        $allowedSorts = ['id', 'title', 'director', 'genre', 'year', 'duration_min'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }
        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'asc';
        }
        
        $stmt = $this->db->prepare("SELECT * FROM movies ORDER BY {$sort} {$order}");
        $stmt->execute();
        $movies = $stmt->fetchAll();

        $this->render('movie/list', [
            'movies' => $movies,
            'currentSort' => $sort,
            'currentOrder' => $order,
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

            if (empty($errors)) {
                $stmt = $this->db->prepare(
                    'INSERT INTO movies (title, director, genre, year, duration_min)
                     VALUES (:title, :director, :genre, :year, :duration_min)'
                );
                $stmt->execute([
                    ':title' => trim($old['title']),
                    ':director' => trim($old['director']),
                    ':genre' => trim($old['genre'] ?? ''),
                    ':year' => (int)($old['year'] ?? 0),
                    ':duration_min' => (int)($old['duration_min'] ?? 0),
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

            if (empty($errors)) {
                $stmt = $this->db->prepare(
                    'UPDATE movies SET title = :title, director = :director, genre = :genre,
                     year = :year, duration_min = :duration_min WHERE id = :id'
                );
                $stmt->execute([
                    ':title' => trim($data['title']),
                    ':director' => trim($data['director']),
                    ':genre' => trim($data['genre'] ?? ''),
                    ':year' => (int)($data['year'] ?? 0),
                    ':duration_min' => (int)($data['duration_min'] ?? 0),
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
