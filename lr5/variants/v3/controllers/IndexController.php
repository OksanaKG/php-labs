<?php

class IndexController extends PageController
{
    public function action_main(): void
    {
        $db = Database::getInstance();
        $stmt = $db->prepare(
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

        $this->render('index/main', ['movies' => $movies], 'Головна');
    }
}
