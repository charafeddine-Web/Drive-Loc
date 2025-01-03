<?php
require_once '../autoload.php';

use Classes\Category;

if (isset($_GET['id_category'])) {
    $id_category = $_GET['id_category'];
    try {
        $category = new Category(null, null, null);
        $rs = $category->DeleteCategory($id_category);
        
        if ($rs) {
            header('Location: listCategory.php');
            exit; 
        } else {
            echo 'Category not found or unable to delete.';
        }
    } catch (PDOException $e) {
        echo 'Error deleting Category: ' . $e->getMessage();
    }
}
?>
