<?php
require_once '../classes/Tage.php';

if (isset($_GET['idTag'])) {
    $idTag = $_GET['idTag'];
    try {
        $tag = new tag(null, null);
        $tagDetails = $tag->GetTagById($idTag);

        if ($tagDetails) {
            $name = htmlspecialchars($tagDetails['name']);
            echo "<div><strong>Name:</strong> $name 😁</div>";
        } else {
            echo "tag not found!";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No tag ID provided!";
}
