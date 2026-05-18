<?php
require_once '../core/Controller.php';

class CommentController extends Controller {

    // Přidání komentáře
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }

            $videoId = (int)$_POST['video_id'];
            $content = htmlspecialchars(trim($_POST['content']));

            if (!empty($content)) {
                require_once '../app/models/Database.php';
                require_once '../app/models/Comment.php';
                
                $db = (new Database())->getConnection();
                $commentModel = new Comment($db);
                
                $commentModel->create($videoId, $_SESSION['user_id'], $content);
            }

            // Vrátíme uživatele zpět na video
            header('Location: ' . BASE_URL . '/index.php?url=video/show/' . $videoId);
            exit;
        }
    }

    // Smazání komentáře
    public function delete($id = null) {
        if (!$id || !isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Comment.php';
        
        $db = (new Database())->getConnection();
        $commentModel = new Comment($db);
        
        $comment = $commentModel->getById($id);

        if ($comment) {
            // Kontrola práv: smazat může autor komentáře NEBO administrátor
            $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
            $isAuthor = $comment['user_id'] == $_SESSION['user_id'];

            if ($isAuthor || $isAdmin) {
                $commentModel->delete($id);
            }
        }

        // Návrat zpět na video (vezmeme si video_id ze smazaného komentáře)
        header('Location: ' . BASE_URL . '/index.php?url=video/show/' . $comment['video_id']);
        exit;
    }
}