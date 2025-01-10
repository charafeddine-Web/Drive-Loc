<?php
require_once '../../autoload.php'; 
require_once '../classes/Article.php';

try {
    $idArticle = $_GET['idArticle'] ?? null; 

    if (!$idArticle) {
        throw new Exception("Article ID is required.");
    }
    $acArt = new Article($idArticle, null, null, null, null, null, null, null, null, null);
    $art = $acArt->AccepteArt();

    if ($art) {
        header('Location: listArticle.php');
        exit;
    } else {
        echo "Error accepting the Article.";
    }
} catch (\PDOException $e) {
    echo "Error accepting Article: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    
}
