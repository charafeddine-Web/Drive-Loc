

<?php
require_once '../autoload.php';
use Classes\Category;

if (isset($_GET['id_category'])) {
    $id_category = $_GET['id_category'];

    try {
        $category = new Category(null, null, null);
        $details = $category->ShowDetails($id_category); 

        if ($details) {
            echo '<strong>Name:</strong> ' . htmlspecialchars($details[0]->name) . '<br>';
            echo '<strong>Description:</strong> ' . htmlspecialchars($details[0]->description) . '<br>';
            echo'</div>';
        } else {
            echo 'Vehicle not found.';
        }
    } catch (PDOException $e) {
        echo 'Error fetching Category details: ' . $e->getMessage();
    }
} else {
    echo 'No Category selected.';
}
?>
