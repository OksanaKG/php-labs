<?php

class IndexController extends PageController
{
    public function action_main(): void
    {
        $db = Database::getInstance();
        $sort = $_GET['sort'] ?? 'id';
        $order = $_GET['order'] ?? 'asc';
        $allowedSorts = ['id','title','year','duration_min','genre'];
        if (!in_array($sort, $allowedSorts)) $sort = 'id';
        if (!in_array($order, ['asc','desc'])) $order = 'asc';
        $filterGenre = trim($_GET['genre'] ?? '');

        if ($filterGenre !== '') {
            $stmt = $db->prepare(
                "SELECT m.*, COUNT(DISTINCT mc.id) as comments_count, COUNT(DISTINCT mr.id) as reactions_count
                 FROM movies m
                 LEFT JOIN movie_comments mc ON m.id = mc.movie_id
                 LEFT JOIN movie_reactions mr ON m.id = mr.movie_id
                 WHERE m.genre = :genre
                 GROUP BY m.id
                 ORDER BY " . $sort . " " . $order
            );
            $stmt->execute([':genre' => $filterGenre]);
        } else {
            $stmt = $db->prepare(
                "SELECT m.*, COUNT(DISTINCT mc.id) as comments_count, COUNT(DISTINCT mr.id) as reactions_count
                 FROM movies m
                 LEFT JOIN movie_comments mc ON m.id = mc.movie_id
                 LEFT JOIN movie_reactions mr ON m.id = mr.movie_id
                 GROUP BY m.id
                 ORDER BY " . $sort . " " . $order
            );
            $stmt->execute();
        }
        $movies = $stmt->fetchAll();

        // genres for filter
        $gstmt = $db->prepare('SELECT DISTINCT genre FROM movies WHERE genre IS NOT NULL AND genre != "" ORDER BY genre');
        $gstmt->execute();
        $genres = array_map(fn($r)=>$r['genre'], $gstmt->fetchAll());

        $this->render('index/main', ['movies' => $movies, 'genres' => $genres, 'currentSort' => $sort, 'currentOrder' => $order, 'currentGenre' => $filterGenre], 'Головна');
    }
}
