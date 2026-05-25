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

        // Products revenue (simple JSON storage)
        $productsDir = DATA_DIR . '/products';
        $purchasesFile = $productsDir . '/purchases.json';
        $productRevenue = 0.0;
        $productSold = 0;
        if (file_exists($purchasesFile)) {
            $purchases = json_decode(file_get_contents($purchasesFile), true) ?: [];
            foreach ($purchases as $rec) {
                $productSold++;
                $productRevenue += (float)($rec['price'] ?? 0.0);
            }
        }

        if (!$totals) $totals = ['total_revenue' => 0.0, 'tickets_sold' => 0];
        $totals['product_revenue'] = $productRevenue;
        $totals['product_sold'] = $productSold;
        $totals['combined_revenue'] = (float)($totals['total_revenue'] ?? 0) + $productRevenue;

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
