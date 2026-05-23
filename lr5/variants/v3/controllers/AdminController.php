<?php

class AdminController extends PageController
{
    private PDO $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();
    }

    public function action_index(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] !== 1) {
            $this->redirect('auth/login');
            return;
        }

        // Total revenue
        $stmt = $this->db->prepare('SELECT SUM(price) as total_revenue, COUNT(*) as tickets_sold FROM tickets');
        $stmt->execute();
        $totals = $stmt->fetch();

        // Popular films (tickets per movie)
        $stmt = $this->db->prepare(
            "SELECT m.id, m.title, COUNT(t.id) as sold
             FROM movies m
             LEFT JOIN screenings s ON s.movie_id = m.id
             LEFT JOIN tickets t ON t.screening_id = s.id
             GROUP BY m.id
             ORDER BY sold DESC"
        );
        $stmt->execute();
        $popular = $stmt->fetchAll();

        $this->render('admin/index', [
            'totals' => $totals,
            'popular' => $popular,
        ], 'Адмін-панель');
    }
}
