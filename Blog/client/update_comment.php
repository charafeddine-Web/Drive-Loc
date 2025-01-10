<?php
require_once '../classes/Comment.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_id'], $_POST['content'])) {
    $commentId = $_POST['comment_id'];

    try {
        $updated = new Comment($commentId);
        $updated->updateComment();
        if ($updated) {
            echo "<script>alert('Commentaire mis à jour avec succès.');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
            exit();
        } else {
            echo "<p class='text-red-600'>Impossible de mettre à jour le commentaire.</p>";
        }
    } catch (\PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
