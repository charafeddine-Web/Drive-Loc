<?php

require_once '../classes/Tage.php';

if(isset($_GET['idTag'])){  
    $idTag = $_GET['idTag'];  
}

try{
    $tag = new Tag($idTag);
    if($tag->DeleteTag()){  
        header("Location: listTags.php");  
        exit;
    } else {
        echo "<script>alert('Error deleting the Tag.');</script>";  
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage(); 
}
