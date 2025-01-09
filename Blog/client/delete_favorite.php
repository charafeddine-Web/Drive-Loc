<?php

require_once '../classes/Favorites.php';

$id_user=$_POST['id_user'];
$idArticle=$_POST['idArticle'];

if(isset($_POST['idArticle'])){  
    $idArticle = $_POST['idArticle'];  
}else{
    echo "id article not found ";
}
try{
    $tag = new Favorites($id_user,$idArticle,);
        if($tag->removeFavorite()){  
        header("Location: favoris.php");  
        exit;
    } else {
        echo "<script>alert('Error deleting the Tag.');</script>";  
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage(); 
}
