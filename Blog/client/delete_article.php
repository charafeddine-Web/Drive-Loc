<?php

require_once '../classes/Article.php';

if(isset($_POST['article_id'])){  
    $article_id = $_POST['article_id'];  
}else{
    echo "id article not found ";
}

try{
    $tag = new Article(null,null,null,null,null,null,null,null,null,null);
    if($tag->DeleteArticle($article_id)){  
        header("Location: index.php");  
        exit;
    } else {
        echo "<script>alert('Error deleting the Tag.');</script>";  
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage(); 
}
