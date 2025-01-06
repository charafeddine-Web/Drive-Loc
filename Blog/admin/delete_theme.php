<?php

require_once '../classes/theme.php';

if(isset($_GET['idTheme'])){  
    $idTheme = $_GET['idTheme'];  
}

try{
    $them = new Theme(null, null, null);
  
    if($them->DeleteTheme($idTheme)){  
        header("Location: listTheme.php");  
        exit;
    } else {
        echo "<script>alert('Error deleting the theme.');</script>";  
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage(); 
}
