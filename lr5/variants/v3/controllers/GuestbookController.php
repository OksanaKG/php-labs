<?php

class GuestbookController extends PageController
{
    private string $filePath;

    public function __construct()
    {
        parent::__construct();
        $this->filePath = DATA_DIR . '/comments.jsonl';
    }

    public function action_index(): void
    {
        $message = '';
        $errors = [];
        $shouldRedirect = false;

        if ($this->request->isPost()) {
            if (isset($_POST['delete_index'])) {
                // Handle delete
                $deleteIndex = (int)$_POST['delete_index'];
                if ($this->deleteComment($deleteIndex)) {
                    $_SESSION['guestbook_message'] = 'Коментар видалено!';
                    $shouldRedirect = true;
                } else {
                    $errors['delete'] = 'Не вдалося видалити коментар.';
                }
            } else {
                // Handle add comment
                $name = trim($this->request->post('name', ''));
                $comment = trim($this->request->post('comment', ''));

                if ($name === '') {
                    $errors['name'] = "Ім'я є обов'язковим.";
                }
                if ($comment === '') {
                    $errors['comment'] = 'Коментар є обов\'язковим.';
                }

                if (empty($errors)) {
                    $name = str_replace(["\r", "\n"], ' ', $name);
                    $comment = str_replace(["\r", "\n"], ' ', $comment);
                    $userId = $_SESSION['user_id'] ?? null;
                    $entry = json_encode([
                        'date' => date('Y-m-d H:i'),
                        'name' => $name,
                        'comment' => $comment,
                        'user_id' => $userId,
                    ], JSON_UNESCAPED_UNICODE);
                    file_put_contents($this->filePath, $entry . PHP_EOL, FILE_APPEND | LOCK_EX);
                    $_SESSION['guestbook_message'] = 'Коментар додано!';
                    $shouldRedirect = true;
                }
            }
        }

        // Redirect after successful POST to prevent duplicate submissions on page refresh
        if ($shouldRedirect) {
            $this->redirect('guestbook/index');
            return;
        }

        // Display message from previous redirect if it exists
        if (isset($_SESSION['guestbook_message'])) {
            $message = $_SESSION['guestbook_message'];
            unset($_SESSION['guestbook_message']);
        }

        $comments = $this->readComments();

        $this->render('guestbook/index', [
            'comments' => $comments,
            'message' => $message,
            'errors' => $errors,
        ], 'Гостьова книга');
    }

    private function readComments(): array
    {
        $comments = [];

        if (!file_exists($this->filePath)) {
            return $comments;
        }

        $lines = file($this->filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $entry = json_decode($line, true);
            if (is_array($entry) && isset($entry['date'], $entry['name'], $entry['comment'])) {
                $comments[] = $entry;
            }
        }

        return array_reverse($comments);
    }

    private function deleteComment(int $index): bool
    {
        if (!file_exists($this->filePath)) {
            return false;
        }

        $lines = file($this->filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $comments = [];

        foreach ($lines as $line) {
            $entry = json_decode($line, true);
            if (is_array($entry) && isset($entry['date'], $entry['name'], $entry['comment'])) {
                $comments[] = $entry;
            }
        }

        // Comments are displayed in reverse order (newest first)
        // So index 0 is the newest comment, which is the last in the file
        $fileIndex = count($comments) - 1 - $index;

        if ($fileIndex < 0 || $fileIndex >= count($comments)) {
            return false;
        }

        $commentToDelete = $comments[$fileIndex];
        $currentUserId = $_SESSION['user_id'] ?? null;
        
        // Check if current user can delete this comment
        // Allow if: user is admin OR user is the author of the comment
        $canDelete = false;
        
        // Check if user is admin
        if ($currentUserId) {
            $db = Database::getInstance();
            try {
                $stmt = $db->prepare('SELECT is_admin FROM users WHERE id = :id');
                $stmt->execute([':id' => $currentUserId]);
                $user = $stmt->fetch();
                if ($user && (bool)$user['is_admin']) {
                    $canDelete = true;
                }
            } catch (Exception $e) {
                // Fallback: check by login name
                try {
                    $stmt = $db->prepare('SELECT login FROM users WHERE id = :id');
                    $stmt->execute([':id' => $currentUserId]);
                    $user = $stmt->fetch();
                    if ($user && $user['login'] === 'admin') {
                        $canDelete = true;
                    }
                } catch (Exception $e2) {
                    // Continue without admin check
                }
            }
        }
        
        // Check if user is the author of the comment
        if (!$canDelete && $currentUserId && isset($commentToDelete['user_id']) && $commentToDelete['user_id'] == $currentUserId) {
            $canDelete = true;
        }
        
        if (!$canDelete) {
            return false;
        }

        // Remove the comment from the array
        array_splice($comments, $fileIndex, 1);

        // Write back to file
        $content = '';
        foreach ($comments as $comment) {
            $content .= json_encode($comment, JSON_UNESCAPED_UNICODE) . PHP_EOL;
        }

        return file_put_contents($this->filePath, $content, LOCK_EX) !== false;
    }
}
