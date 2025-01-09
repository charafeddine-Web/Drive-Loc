<?php
require_once '../classes/Favorites.php';
require './Add_favoris.php';
session_start();

if ((!isset($_SESSION['id_user']) && $_SESSION['id_role'] !== 2)) {
    header("Location: ../../Visiteur/login.php");
    exit;
}
$userId=$_SESSION['id_user'];
try{
    $favorite=new Favorites(null,null);
    $favorites=$favorite->getUserFavorites($userId);

}catch (\PDOException $e) {
    echo "Error fetching Favorites Article: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Favoris</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Mes Favoris</h1>
        
        <?php if (!empty($favorites)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($favorites as $article): ?>
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <h2 class="text-xl font-semibold mb-2"><?= htmlspecialchars($article['title']) ?></h2>
                        <p class="text-gray-600 mb-4"><?= htmlspecialchars(substr($article['content'], 0, 100)) ?>...</p>
                        <div class="flex items-center justify-between">
                        <a href="article.php?id=<?= $article['idArticle'] ?>" 
                        class="text-blue-500 hover:underline">Lire plus</a>
                        <form action="delete_favorite.php" method="post">
                            <input type="hidden" name="idArticle" value="<?= $article['idArticle'] ?>">
                            <input type="hidden" name="id_user" value="<?= $_SESSION['id_user'] ?>">
                            <button type="submit" class="text-red-600">Delete</button>
                        </form>
                        </div>
                       
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-600">Vous n'avez aucun article favori pour le moment.</p>
        <?php endif; ?>
    </div>
</body>
</html>
