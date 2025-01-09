<?php
require_once '../classes/Favorites.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitcommentfavoris'])) {
   
    if (!$_POST['id_article']) {
        echo "Article does not exist.";
    }

    $id_article = $_POST['id_article'];
    $userId = $_POST['user_id'];

    $comment = new Favorites($userId,$id_article);

    if ($comment->addFavorite()) {
        header("Location: index.php?id=$articleId"); 
        exit();
    } else {
        echo "Failed to add comment.";
    }
}

