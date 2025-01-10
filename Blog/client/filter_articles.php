<?php
require '../classes/Article.php';

$themeId = $_GET['theme_id'] ?? null;

if ($themeId) {
    $articles = new Article(null,null,null,null,null,null,null,null,null,null);
    $filteredArticles = $articles->getFilteredArticles($themeId);

    if ($filteredArticles) {
        foreach ($filteredArticles as $article) {
            if ($article['status'] === 'accepted') {
                echo '<div class="bg-white rounded-lg shadow-md overflow-hidden ">';
                echo '<div class="p-4">';
                echo '<h3 class="text-lg font-bold text-gray-800 mb-2">' . htmlspecialchars($article['title']) . '</h3>';
                echo '<p class="text-sm text-gray-600 truncate">' . htmlspecialchars($article['content']) . '</p>';
                echo '<a href="details.php?id_article=' . htmlspecialchars($article['idArticle']) . '" class="text-blue-600">Read More</a>';
                echo '</div>';
                echo '</div>';
            }
        }
    } else {
        echo '<p class="text-gray-600">No articles found for the selected theme.</p>';
    }
} else {
    echo '<p class="text-gray-600">Please select a theme to filter articles.</p>';
}
