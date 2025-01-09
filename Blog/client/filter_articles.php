<?php
// Include necessary files
require_once '../classes/Article.php';

$article = new Article();

$themeId = isset($_GET['theme_id']) ? $_GET['theme_id'] : null;
$articles = $article->getFilteredArticles($themeId);
if ($articles) {
    foreach ($articles as $article) {
        echo "<div class='bg-white rounded-lg shadow-md overflow-hidden'>";
        echo "<h3 class='text-lg font-bold text-gray-800 mb-2'>" . htmlspecialchars($article['title']) . "</h3>";
        echo "<p class='text-sm text-gray-600'>" . htmlspecialchars($article['content']) . "</p>";
        echo "</div>";
    }
} else {
    echo "<p class='text-gray-600 text-lg mt-8 text-center'>No articles found for this theme.</p>";
}
?>
