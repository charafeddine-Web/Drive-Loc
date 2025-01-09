<?php
require_once '../classes/Comment.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitcomment'])) {
    if (!$_POST['article_id']) {
        echo "Article does not exist.";
    }
    $content = trim($_POST['comments']); 
    if (empty($content)) {
        die("Comment content cannot be empty.");
    }
    
    
    $articleId = $_POST['article_id'];
    $userId = $_POST['user_id'];

    $comment = new Comment(null,$content,null,$articleId,$userId);

    if ($comment->addComment()) {
        header("Location: index.php?id=$articleId"); 
        exit();
    } else {
        echo "Failed to add comment.";
    }
}
?>
