<?php
require_once '../classes/Comment.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitcomment'])) {
    $content = trim($_POST['comments']);
    $articleId = filter_input(INPUT_POST, 'articleId', FILTER_SANITIZE_NUMBER_INT);
    $userId = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);

    if (empty($content)) {
        die("Comment content cannot be empty.");
    }
    if (empty($articleId) || empty($userId)) {
        die("Invalid article or user ID.");
    }
    $comment = new Comment(null, $content, null, $articleId, $userId);

    if ($comment->addComment()) {
        header("Location: blogs.php?id=$articleId");
        exit();
    } else {
        echo "Failed to add comment.";
    }
}
?>
