<?php
require_once '../classes/theme.php';

if (isset($_GET['idTheme'])) {
    $idTheme = $_GET['idTheme'];
    try {
        $theme = new Theme(null, null, null);
        $themeDetails = $theme->GetThemeDetails($idTheme);

        if ($themeDetails) {
            $name = htmlspecialchars($themeDetails['name']);
            $description = htmlspecialchars(    $themeDetails['description']);
            echo "<div><strong>Name:</strong> $name</div>";
            echo "<div><strong>Description:</strong> $description</div>";
        } else {
            echo "Theme not found!";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No theme ID provided!";
}
