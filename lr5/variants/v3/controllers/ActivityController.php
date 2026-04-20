<?php

class ActivityController extends PageController
{
    private PDO $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();
    }

    public function action_list(): void
    {
        $stmt = $this->db->prepare(
            "SELECT a.*, COALESCE(SUM(av.vote_value), 0) as total_votes, COUNT(DISTINCT av.user_id) as voter_count
             FROM activities a
             LEFT JOIN activity_votes av ON a.id = av.activity_id
             WHERE a.active = 1
             GROUP BY a.id
             ORDER BY a.created_at DESC"
        );
        $stmt->execute();
        $activities = $stmt->fetchAll();

        // Get user's votes if logged in
        $userVotes = [];
        if (isset($_SESSION['user_id'])) {
            $stmt = $this->db->prepare(
                "SELECT activity_id FROM activity_votes WHERE user_id = :uid"
            );
            $stmt->execute([':uid' => $_SESSION['user_id']]);
            $userVotes = $stmt->fetchAll(PDO::FETCH_COLUMN);
        }

        $this->render('activity/list', [
            'activities' => $activities,
            'userVotes' => $userVotes,
        ], 'Активності кінотеатру');
    }

    public function action_vote(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Not logged in']);
            exit;
        }

        $activityId = (int)$this->request->post('activity_id', 0);

        if ($activityId > 0) {
            try {
                // Check if user already voted
                $stmt = $this->db->prepare(
                    "SELECT id FROM activity_votes 
                     WHERE activity_id = :aid AND user_id = :uid"
                );
                $stmt->execute([':aid' => $activityId, ':uid' => $_SESSION['user_id']]);
                $existingVote = $stmt->fetch();

                if ($existingVote) {
                    // Delete vote (toggle)
                    $stmt = $this->db->prepare(
                        "DELETE FROM activity_votes 
                         WHERE activity_id = :aid AND user_id = :uid"
                    );
                    $stmt->execute([':aid' => $activityId, ':uid' => $_SESSION['user_id']]);
                    $voted = false;
                } else {
                    // Add vote
                    $stmt = $this->db->prepare(
                        "INSERT INTO activity_votes (activity_id, user_id, vote_value)
                         VALUES (:aid, :uid, 1)"
                    );
                    $stmt->execute([':aid' => $activityId, ':uid' => $_SESSION['user_id']]);
                    $voted = true;
                }

                // Get updated vote count
                $stmt = $this->db->prepare(
                    "SELECT COALESCE(SUM(vote_value), 0) as total_votes, COUNT(DISTINCT user_id) as voter_count
                     FROM activity_votes WHERE activity_id = :aid"
                );
                $stmt->execute([':aid' => $activityId]);
                $result = $stmt->fetch();

                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'voted' => $voted,
                    'total_votes' => (int)$result['total_votes'],
                    'voter_count' => (int)$result['voter_count'],
                ]);
                exit;
            } catch (PDOException $e) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Vote failed: ' . $e->getMessage()]);
                exit;
            }
        }

        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid activity']);
        exit;
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

            if (empty(trim($old['title'] ?? ''))) {
                $errors['title'] = 'Назва активності є обов\'язковою.';
            }

            if (empty($errors)) {
                $stmt = $this->db->prepare(
                    'INSERT INTO activities (title, description, activity_type)
                     VALUES (:title, :desc, :type)'
                );
                $stmt->execute([
                    ':title' => trim($old['title']),
                    ':desc' => trim($old['description'] ?? ''),
                    ':type' => trim($old['activity_type'] ?? 'charity'),
                ]);

                $_SESSION['flash_success'] = 'Активність додано!';
                $this->redirect('activity/list');
                return;
            }
        }

        $this->render('activity/create', [
            'errors' => $errors,
            'old' => $old,
        ], 'Додати активність');
    }

    private function isAdmin(): bool
    {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        
        try {
            $stmt = $this->db->prepare('SELECT login FROM users WHERE id = :id');
            $stmt->execute([':id' => $_SESSION['user_id']]);
            $user = $stmt->fetch();
            return $user && $user['login'] === 'admin';
        } catch (Exception $e) {
            return false;
        }
    }
}
