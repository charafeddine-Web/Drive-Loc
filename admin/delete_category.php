<?php
require_once '../autoload.php';

use Classes\Category;
if (isset($_GET['id_category'])) {
    $id_category = $_GET['id_category'];
    try {
        $category = new Category(null,null,null,);
        $st=$category->DeleteCategory($id_category);
        if($st){
            echo '<script>alert("Category deleted successfully.")</script>';
            header('Location: listCategory.php');
            exit;
        }
       
    } catch (PDOException $e) {
        echo 'Error deleting Category: ' . $e->getMessage();
    }
}
?>
