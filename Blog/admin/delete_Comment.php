<?php

require_once '../classes/Comment.php';

if(isset($_GET['id_Comment'])){  
    $idComments = $_GET['id_Comment'];  
}

try{
    $them = new Comment($idComments, null, null,null,null);
  
    if($them->DeleteComment()){  
        header("Location: listcomments.php");  
        exit;
    } else {
        echo "<script>alert('Error deleting the comment.');</script>";  
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage(); 
}
