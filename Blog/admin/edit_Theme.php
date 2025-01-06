<?php

require_once '../classes/theme.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editThemeId'])) {
    $idTheme = $_POST['editThemeId'];
    $name = $_POST['editThemeName'];
    $description = $_POST['editThemeDescription'];

    try {
        $theme = new Theme($idTheme, $name, $description);
        $isUpdated = $theme->EditTheme($idTheme);
        if ($isUpdated) {
            header("Location: listTheme.php");
            exit;
        } else {
            echo "Failed to update the theme.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
