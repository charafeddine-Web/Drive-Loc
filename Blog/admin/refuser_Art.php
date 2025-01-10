<?php
require_once '../../autoload.php'; 
require_once '../classes/Article.php';

try {
    $idArticle = $_GET['idArticle'] ?? null; 

    if (!$idArticle) {
        throw new Exception("Article ID is required.");
    }
    $acRes = new Article($idArticle, null, null, null, null, null, null, null, null, null);
    $res = $acRes->RefuseArt();

    if ($res) {
        header('Location: listArticle.php');
        exit;
    } else {
        echo "Error Refusing the article.";
    }
} catch (\PDOException $e) {
    echo "Error Refusing Article: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
